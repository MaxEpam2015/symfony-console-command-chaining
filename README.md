# Console Command Chaining

## Bundle structure and registration:
#### You can add bundle to the Oro namespace (src/Oro)
#### including main bundle class for register bundle
#### and Command for executing in console. Then register
#### bundles in the [bundles.php](config%2Fbundles.php)

## Command Chaining functionality:
#### Every Command class must include RunChainCommand trait
#### In the core method `commandsRegistration()` of class `CommandsHandler`
#### register command names that you want to add into chain functionality.
#### Make sure that your structure is right: field $registeredChainCommands
#### must consist array with `main` and `member` keys. `main` key must consist 
#### only one command name as string. `member` key must consist one or more
#### command names ad array.

## P.S.:
#### EventListener provided to make possibility extend functionality in the future 
#### to use queue for example. But, of course, it needs some changes for that.