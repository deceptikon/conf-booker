<?php
header('Access-Control-Allow-Origin: *'); 
header('Access-Control-Allow-Headers: origin, content-type, accept');
// require 'vendor/autoload.php';

$loader = require 'vendor/autoload.php';
$loader->add('ConfBooker', __DIR__.'./src/ConfBooker');

// setup Propel
require_once 'generated-conf/config.php';

use GraphQL\GraphQL;
use GraphQL\Language\Parser;
use GraphQL\Utils\BuildSchema;
use GraphQL\Utils\AST;
use GraphQL\Type\Definition\ResolveInfo;
use Propel\Runtime\Propel;

use Monolog\Logger;
use Monolog\Handler\StreamHandler;
$logger = new Logger('defaultLogger');
$logger->pushHandler(new StreamHandler('php://stderr'));
Propel::getServiceContainer()->setLogger('defaultLogger', $logger);

define("DEBUG", true);

function get($str) {
  $words = explode('_', $str);
  $words = array_map('ucfirst', $words);
  $str = implode('', $words);
  return "get".$str;
}

function set($str) {
  $words = explode('_', $str);
  $words = array_map('ucfirst', $words);
  $str = implode('', $words);
  return "set".$str;
}


function getSchema() {
  $cacheFilename = 'cached_schema.php';

  $typeConfigDecorator = function($typeConfig, $typeDefinitionNode) {
      $name = $typeConfig['name'];
      // ... add missing options to $typeConfig based on type $name
      $typeConfig['resolveField'] = function($value, $args, $context, ResolveInfo $info) {

        $parentName = $info->parentType->name;
        $resolverName = $info->fieldName;
        $isMutation = $parentName === 'Mutation';
        $isQuery = $parentName === 'Query';
        $className = null;
        $isObject = false;
        $isField = false;



        // If it is a top-level object
        if ($parentName === 'Query' || $parentName === 'Mutation') {
          $isObject = true;
          $isField = false;
          $className = "\ConfBooker\\".$resolverName;
        // if it is a field of some class
        } else if (class_exists("\ConfBooker\\".$parentName)) {
          $isObject = false;
          $isField = true;
          $className = "\ConfBooker\\".$parentName;
        } else {
          return $value;
        }

        if ($isMutation) {
          if (isset($args['id'])) {
            $className .= 'Query';
            $obj = $className::create()->findOneById($args['id']);
          } else if (isset($args['phone'])) {
            $className .= 'Query';
            $obj = $className::create()->findOneByPhone($args['phone']);
          } else {
            if (class_exists($className)) {
              $obj = new $className();
            } else {
              $m = new \ConfBooker\Mutations;
              return $m->$resolverName($args);
            }
          }
          foreach($args['data'] as $field => $val){
            $fld = set($field);
            $obj->$fld($val);
          }
          $obj->save();

          $m = new \ConfBooker\Email;
          $m->sendInvitation($obj->getEmail(), $obj->getFullname(), $obj->getId(), $obj->getIsMember());
          return $obj;
        }
          
        if ($isQuery) {
          $className .= 'Query';
          $res = [];
          if (isset($args['phone'])) {
            $obj = new $className();
            $res[] = $obj->findOneByPhone($args['phone']);
          } else {
           $obj = $className::create()->find();
           foreach($obj as $r) {
             $res[] = $r;
           }
          } 
          return $res;
        }

        if ($isObject) {
          return $res;
        } else if ($isField) {
          $field = get($resolverName);
          $q = !isset($res) || is_null($res) ? $value : $res;
          if($q) {
            return  $q->$field();
          }
        }
      };
      return $typeConfig;
  };

  if (DEBUG || !file_exists($cacheFilename)) {
      $document = Parser::parse(file_get_contents('./schema.graphql'));
      file_put_contents($cacheFilename, "<?php\nreturn " . var_export(AST::toArray($document), true). ";");
  } else {
      $cache = require $cacheFilename;
      $document = AST::fromArray($cache); // fromArray() is a lazy operation as well
  }


  $schema = BuildSchema::build($document, $typeConfigDecorator);
  return $schema;
};

$settings =  [
    'settings' => [
        'displayErrorDetails' => true,
    ],
];

$app = new Slim\App($settings);



$app->map(['GET', 'POST'], '/graphql', function ($request, $response, $args) {

    try {
        $schema = getSchema();
        $vars = $request->getParsedBody();
        $rootValue = ['prefix' => 'You said: '];
        $result = GraphQL::executeQuery($schema, $vars['query'], $rootValue, null, $vars['variables']);
        $output = $result->toArray(DEBUG);
    } catch (\Exception $e) {
        $output = [
            'errors' => [
                [
                    'message' => $e->getMessage()
                ]
            ]
        ];
    }
    return $response->getBody()->write(json_encode($output));
});

$app->run();
