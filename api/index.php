<?php

// require 'vendor/autoload.php';

$loader = require 'vendor/autoload.php';
$loader->add('ConfBooker', __DIR__.'./src/ConfBooker');

use GraphQL\GraphQL;
use GraphQL\Language\Parser;
use GraphQL\Utils\BuildSchema;
use GraphQL\Utils\AST;
use GraphQL\Type\Definition\ResolveInfo;


define("DEBUG", true);

function getSchema() {
  $cacheFilename = 'cached_schema.php';

  $typeConfigDecorator = function($typeConfig, $typeDefinitionNode) {
      $name = $typeConfig['name'];
      // ... add missing options to $typeConfig based on type $name
      $typeConfig['resolveField'] = function($value, $args, $context, ResolveInfo $info) {

        $parentName = $info->parentType->name;
        $resolverName = $info->fieldName;
        $isMutation = $parentName === 'Mutation';
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
          
        $obj = new $className();

        if ($isObject) {
          return $obj;
        } else if ($isField) {
          return  $obj->$resolverName;
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
