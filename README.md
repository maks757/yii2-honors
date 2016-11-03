# yii2 honors
## status extension dev

#### Install
```
composer.phar require maks757/yii2-honors
```
or
```
composer require maks757/yii2-honors
```
and applying migrations
```
php yii migrate --migrationPath=@vendor/maks757/yii2-honors/migrations
```
or
```
yii migrate --migrationPath=@vendor/maks757/yii2-honors/migrations
```

#### Configuration

##### main.php (config)
```php
'modules' => [
    'honor' => [
        'class' => \bl\honors\HonorsModule::className()
    ],
],
'components' => [
    // Images config
    'imagableHonor' => [
        'class' => 'bl\imagable\Imagable',
        'imageClass' => \bl\honors\components\image\CreateImageImagine::className(),
        'nameClass' => \bl\honors\components\image\GenerateName::className(),
        'imagesPath' => '@frontend/web/honorImage',
        'categories' => [
            'category' => [
                'honor' => [
                    'origin' => false,
                    'size' => [
                        'long' => [
                            'width' => 500,
                            'height' => 500,
                        ],
                        'short' => [
                            'width' => 200,
                            'height' => 200,
                        ],
                    ]
                ],
            ]
        ]
    ],
    // ...
]
```
url to list honor = admin panel url + /honor/honor/list
url to create honor = admin panel url + /honor
url to list user honor = admin panel url + /honor/honor/user
#### Using
![Alt text](/image/img1.PNG "Optional title")
```php
    /**
    *@var Progress $progress
    */
    $progress = Yii::$app->progress;
```
and
```php 
    // First variant
    // 1 param ( progress category )
    // 2 param ( user id )
    $progress->validateOne('userConfirm', 1);
```
or  
```php
    // Second variant
    // 1 param ( progress category )
    // its use current user id
    $progress->validate('userConfirm');
```
#### Using example
```php
$userProgress = \bl\progress\entities\UserProgress::getUserProgress($userRegisterInfo->id);
foreach ($userProgress as $value)
{
    /** *@var Progress $progress */
    $progress = Yii::$app->progress;
    $pathImage = $progress->getImage($value->image->image, 'progress', 'short');

    $content = Html::tag('h3', $value->name);
    $content .= Html::img($pathImage);
    echo Html::tag('div', $content, ['class' => 'col-sm-2']);
}
```
![Alt text](/image/author.jpg "Optional title")