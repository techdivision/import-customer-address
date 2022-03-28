
# Version 16.0.4

## Bugfixes

* Update customer address on new column _address_increment_id

## Features

* none

# Version 16.0.3

## Bugfixes

* none

## Features

* Import multiple customer addresse on increment_id

* # Version 16.0.2

## Bugfixes

* none

## Features

* Prepare generic workflow and defined deprecated classes

# Version 16.0.1

## Bugfixes

* Fixed import-customer-address#18

## Features

* None

# Version 16.0.0

## Bugfixes

* None

## Features

* Switch to latest techdivision/import-customer 16.* version as dependency

# Version 15.0.0

## Bugfixes

* None

## Features

* Switch to latest techdivision/import-customer 15.* version as dependency

# Version 14.0.2

## Bugfixes

* None

## Features

* Extract dev autoloading

# Version 14.0.1

## Bugfixes

* Fixed typo in Symfony DI configuration

## Features

* None

# Version 14.0.0

## Bugfixes

* Minor bugfixes and optimizations

## Features

* Switch to latest techdivision/import-customer 14.* version as dependency

# Version 13.0.0

## Bugfixes

* None

## Features

* Remove deprecated classes and methods
* Add techdivision/import-cli-simple#216
* Remove unnecessary identifiers from configuration
* Switch to latest techdivision/import-customer 13.* version as dependency

# Version 12.0.0

## Bugfixes

* None

## Features

* Switch to latest techdivision/import-customer 12.* version as dependency

# Version 11.0.0

## Bugfixes

* None

## Features

* Switch to latest techdivision/import-customer 11.* version as dependency

# Version 10.0.0

## Bugfixes

* None

## Features

* Switch to latest techdivision/import-customer 10.* version as dependency

# Version 9.0.1

## Bugfixes

* Fixed invalid observer ID in services.xml

## Features

* None

# Version 9.0.0

## Bugfixes

* None

## Features

* Switch to latest techdivision/import-customer 9.* version as dependency

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