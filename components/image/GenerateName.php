<?php
namespace bl\honors\components\image;

use bl\imagable\name\BaseName;
use yii\base\Security;

class GenerateName extends BaseName
{
    public function generate($baseName)
    {
        $security = new Security();
        return uniqid($security->generateRandomString());
    }
}