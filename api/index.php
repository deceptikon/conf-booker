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
  return "get".ucfirst($str);
}

function set($str) {
  return "set".ucfirst($str);
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
          print($resolverName.'-'.$parentName.":WTF??\n");
        }

        if ($isMutation) {
          if (isset($args['id'])) {
            $className .= 'Query';
            $obj = $className::create()->findOneById($args['id']);
          } else {
            $obj = new $className();
          }
          foreach($args['data'] as $field => $val){
            $fld = set($field);
            $obj->$fld($val);
          }
          $obj->save();
          return $obj;
        }
          
        if ($isQuery) {
          $className .= 'Query';
          $obj = new $className();
          $res = $obj->find();
          return $res;
        }

        if ($isObject) {
          return $res;
        } else if ($isField) {
          $field = get($resolverName);
          $q = is_null($res) ? $value : $res;
          return  $q->$field();
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



$app->post('/graphql', function ($request, $response, $args) {

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
