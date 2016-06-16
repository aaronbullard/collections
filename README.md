# Collection

A base Collection class that when extended will ensure that all items added to the collection are of a single type.  Type can be determined by a static property or inferred from the extended classes namespace.

## Getting started

Clone repo.

#### Install dependencies

From within the cloned folder `collections` run:

Composer dependencies

```
composer install
```

#### Testing

```
composer test
```

## Usage

```
<?php

use Aaronbullard\Collections\Collection;

class Car {
    public $model;

    public function pressHorn(){
        return "Honk!";
    }
}

class CarCollection extends Collection {}

$cars = new CarCollection;

$numOfCars = 10;
$count = 0;
while($count < $numOfCars){
    $cars[$count] = new Car();
    $count++;
}

count($cars); //10
$cars[3]->pressHorn(); //"Honk!"
```
