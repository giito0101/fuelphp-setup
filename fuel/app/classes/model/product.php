<?php
class Model_Product extends Orm\Model
{
    protected static $_properties = array(
        'id',
        'name',
        'price',
        'stock',
        'description',
    );
}