# Version 9.0.1

## Bugfixes

* Fixed invalid observer ID in services.xml

## Features

* None

# Version 9.0.0

## Bugfixes

* None

## Features

* Switch to latest techdivision/import-customer 8.* version as dependency

# Version 8.0.0

## Bugfixes

* None

## Features

* Switch to latest techdivision/import-customer 8.0.* version as dependency

# Version 7.0.0

## Bugfixes

* None

## Features

* Switch to latest techdivision/import-customer 7.0.* version as dependency

# Version 6.0.0

## Bugfixes

* None

## Features

* Switch to latest techdivision/import-customer 6.0.* version as dependency

# Version 5.0.1

## Bugfixes

* Fixed issue in Symfony DI configuration
* Update default configuration files with listeners

## Features

* None

# Version 5.0.0

## Bugfixes

* None

## Features

* Add composite observers to minimize configuration complexity
* Switch to latest techdivision/import 7.0.* version as dependency
* Make Actions and ActionInterfaces deprecated, replace DI configuration with GenericAction + GenericIdentifierAction

# Version 4.0.0

## Bugfixes

* Fixed issue with invalid address entity IDs for default billing + shipping address
* Add missing methods because of CustomerBunchProcessor implements EavAwareProcessorInterface

## Features

* None

# Version 3.0.0

## Bugfixes

* None

## Features

* Switch to latest techdivision/import-customer 3.0.* version as dependency

# Version 2.0.1

## Bugfixes

* Replace persist/delete Method calls in CustomerAddressAttributeObserver with customer address specific versions

## Features

* None

# Version 2.0.0

## Bugfixes

* Override function AttributeObserverTrait::prepareAttributes() to solve issue with unexpected store_id

## Features

* None

# Version 1.0.0

## Bugfixes

* None

## Features

* Initial Release