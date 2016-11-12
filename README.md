# Type Detector
[![Latest Version](https://img.shields.io/github/release/yarcowang/type-detector.php.svg?style=flat-square)](https://github.com/yarcowang/type-detector.php/releases)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[![Build Status](https://img.shields.io/travis/yarcowang/type-detector.php/master.svg?style=flat-square)](https://travis-ci.org/yarcowang/type-detector.php)
[![Total Downloads](https://img.shields.io/packagist/dt/yarcowang/type-detector.php.svg?style=flat-square)](https://packagist.org/packages/yarcowang/type-detector.php)

TypeDetector is php library to detect variable types by the key name and the value. The thinkings inherit from [superunit]("https://github.com/yarcowang/superunit") and [php-schema]("https://github.com/yarcowang/php-schema") ( _both are my experimental projects_ ).

## Usage
Use [composer]("https://getcomposer.org/") to install this library.

`composer require yarco/type-detector`

Use the class's static method `array TypeDetector::detect(array $array)` to get key-value pair of the types.

Example:
```php
use Yarco\TypeDetector;

$result = TypeDetector::detect(['name' => 'yarco', 'age' => 36]);
print_r($result);

/*
it should return

Array
(
    [name] => string
    [age] => smallint
)

*/
```

## Types
Below fields are referenced from [w3schools.com]("http://www.w3schools.com/sql/sql_datatypes.asp").

### Number
MySQL Data Types | SQL Server Data Types | HTML Input Types | Doctrine Types | _Type Detector Supported_
----|----|----|----|----
TINYINT(size) | tinyint |
SMALLINT(size) | smallint | | smallint | _smallint_
MEDIUMINT(size) |
INT(size) | int | range, number | integer | _int_
BIGINT(size) | bigint | | bigint | _bigint_
FLOAT(size,d) | real | 
DOUBLE(size,d) | float(n) | | float | _float_
DECIMAL(size,d) | decimal(p,s) | | decimal | _decimal_
 | numeric(p,s) | 
 | smallmoney |
 | money |
 | bit | | boolean

### Text
MySQL Data Types | SQL Server Data Types | HTML Input Types | Doctrine Types | _Type Detector Supported_
----|----|----|----|----
CHAR(size) | char(n), nchar(n)
VARCHAR(size) | varchar(n), nvarchar(n) | text | string | _string_
TINYTEXT |
TEXT | text, ntext | textarea | text | _text_
BLOB | binary, varbinary | | binary
MEDIUMTEXT |
MEDIUMBLOB |
LONGTEXT | 
LONGBLOB | image | | blob
ENUM(x,y,z,etc.) | | select
SET | 
 | | password | | _password_
 | | color | | _color_
 | | email | | _email_
 | | search
 | | tel
 | | url | | _url_

### Datetime
MySQL Data Types | SQL Server Data Types | HTML Input Types | Doctrine Types | _Type Detector Supported_
----|----|----|----|----
DATE | date | date | date | _date_
DATETIME | datetime, datetime2, smalldatetime | datetime, datetime-local | datetime | _datetime_
TIMESTAMP | timestamp
TIME | time | time | time | _time_
YEAR | | month,week
 | datetimeoffset | datetimetz

### Other
MySQL Data Types | SQL Server Data Types | HTML Input Types | Doctrine Types | _Type Detector Supported_
----|----|----|----|----
    | uniqueidentifier | | guid
JSON | | checkbox |

## Valid Type Definitions

Type Detector Supported Types | Definition | Priority (large first)
----|----|----|----
_smallint_ | type is integer and value less than 100 | 120
_bigint_ | type is integer and value large than 10000 | 120
_int_ | type is integer | 115
_decimal_ | type is float and number of the fraction is either 2 or 3 | 112
_float_ | type is float | 110
_password_ | type is string and value is *** | 100
_color_ | type is string and value match ^#[0-9a-fA-F]{6}$ | 90
_email_ | type is string and value is email | 80
_url_ | type is string and value is url | 70
_date_ | type is string and value match ^\d{2}/\d{2}/\d{4}$ or ^\d{4}-\d{2}-\d{2}$ | 60
_time_ | type is string and value match ^\d{2}:\d{2}:\d{2}$ or ^\d{2}:\d{2}$ | 60
_datetime_ | type is tring and value match ^\d{4}-\d{2}-\d{2}\s\d{2}:\d{2}(?::\d{2})?$ or can be convert to datetime | 55
_string_ | type is string and length less than 27 | 20
_text_ | type is tring | 0

