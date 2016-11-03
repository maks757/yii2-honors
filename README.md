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
Go to add new honor
![Alt text](/image/img1.PNG "Go to add new honor")
and add new honor
![Alt text](/image/img2.PNG "Add new honor")
and add honor to user
![Alt text](/image/img3.PNG "Add honor to user")
#### Using example
```php
//action 
//honors
    $honors = HonorUser::find()->where(['user_id' => $userId])->with(['honor.translations'])->all();
//
//view
<?php if (!empty($honors)): ?>
    <div class="col-md-12">
            <h3 class="about-user">Honors:</h3>
        <div class="row text-center" style="padding: 2px 10px;">
            <?php /** @var $honor \bl\honors\entities\HonorUser*/?>
            <?php foreach ($honors as $honor): ?>
                <div class="col-xs-4 col-sm-3 col-md-1" style="padding: 0;">
                    <img src="<?= $honor->honor->getImage($honor->honor->image) ?>"
                         width="50" height="50"
                         data-toggle="tooltip" data-placement="top"
                         data-original-title="<?= $honor->honor->translation->name ?>">
                </div>
            <?php endforeach; ?>
        </div>
    </div>
<?php endif; ?>
```
![Alt text](/image/author.jpg "Optional title")