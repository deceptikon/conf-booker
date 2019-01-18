<?php

// require 'vendor/autoload.php';

$loader = require 'vendor/autoload.php';
$loader->add('AppName', __DIR__.'./src/');

use GraphQL\GraphQL;
use GraphQL\Language\Parser;
use GraphQL\Utils\BuildSchema;
use GraphQL\Utils\AST;
use GraphQL\Type\Definition\ResolveInfo;

use ConfBooker\User;


define("DEBUG", true);

$mapper = Array(
  "User" => User,
);

function getSchema() {
  $cacheFilename = 'cached_schema.php';

  $typeConfigDecorator = function($typeConfig, $typeDefinitionNode) {
      $name = $typeConfig['name'];
      // ... add missing options to $typeConfig based on type $name
      $typeConfig['resolveField'] = function($value, $args, $context, ResolveInfo $info) {
        if($resolverName == "User") {
          $obj = new User();
          return $obj;
        }
        $parentName = $info->parentType->name;
        // print_r($info->parentType->name);
        $resolverName = "{$info->fieldName}";
         print_r($resolverName . "-" . $parentName);
        if ($resolverName == 'Query') {
          return $value;
        
        }
        $p = new User();
        var_dump($p);
        print($resolverName);
        print(var_dump(class_exists("AST")));
        //$obj = new $resolverName();
        return $obj;
        if (class_exists($resolverName)) {
          $obj = new $resolverName();
          print("==");

          return $obj;
        } else if (class_exists($parentName)) {
          $obj = new $parentName();
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
    $schema = getSchema();
    $vars = $request->getParsedBody();

    try {
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
