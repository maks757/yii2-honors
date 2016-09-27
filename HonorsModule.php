<?php
/**
 * @author Maxim Cherednyk <maks757q@gmail.com, +380639960375>
 */

namespace bl\honors;


use yii\base\Module;

class HonorsModule extends Module
{
    public $controllerNamespace = 'bl\honors\controllers';
    public $defaultRoute = 'honor';
}