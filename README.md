# Laravel Drag and Drop menu builder

bercabang dari https://github.com/lordmacu/wmenu
![Laravel drag and drop menu](https://raw.githubusercontent.com/harimayco/wmenu-builder/master/screenshot.png)

### Installation

1. Run

```php
composer require erendi/menu
```

**_Step 2 & 3 are optional if you are using laravel 5.5_**

2. Tambahkan kelas berikut, ke array "providers" di file config/app.php

```php
Erendi\Menu\MenuServiceProvider::class,
```

3. tambahkan facades di file config/app.php

```php
'Menu' => Erendi\Menu\Facades\Menu::class,
```

4. Run publish

```php
php artisan vendor:publish --provider="Erendi\Menu\MenuServiceProvider"
```

5. Configure (optional) in **_config/menu.php_** :

- **_CUSTOM MIDDLEWARE:_** untuk menambahkan midlleware anda sendiri
- **_TABLE PREFIX:_** default pacakge mempunay 2 table database "menus" and "menu*items" dan membunakan admin* sebagai prefix pada table nya
- **_TABLE NAMES_** anda juga dapat memodifikasi nama table untuk file migration anda di baris ini
- **_Custom routes_** jika anda ingin merubah route path nya anda bisa merubah pada bari ini
- **_Role Access_** jika anda ingin memberikan permision pada menu ada anda dapat atur pada baris ini

6. Jalankan migrasi laravel untuk membuat table pada database anda

```php
php artisan migrate
```

DONE

### Cara penggunaan Menu Builder ini

jika anda ingin menampilkan pada file .blade.php anda tinggal anda atur menu rendernya saja letakan di antara section yg anda buat sendiri

```php
@extends('app') // sesuaikan dengan extend yg anda buat

@section('contents') // baris ini anda sesuaikan dengan milik anda
    {!! Menu::render() !!}
@endsection

//YOU MUST HAVE JQUERY LOADED BEFORE menu scripts
@push('scripts') // jika menggunakan @push pada tempale anda tambah kan di paling akhir baris tags script pada html anda @stack('ext_scripts')
    {!! Menu::scripts() !!}
@endpush
```

### Menggunakan Model

Memanggil model class

```php
use Erendi\Menu\Models\Menus;
use Erendi\Menu\Models\MenuItems;

```

##### Menggunakan Model Class

```php

/* get menu by id*/
$menu = Menus::find(1);
/* or by name */
$menu = Menus::where('name','Test Menu')->first();

/* or get menu by name and the items with EAGER LOADING (RECOMENDED for better performance and less query call)*/
$menu = Menus::where('name','Test Menu')->with('items')->first();
/*or by id */
$menu = Menus::where('id', 1)->with('items')->first();

//you can access by model result
$public_menu = $menu->items;

//or you can convert it to array
$public_menu = $menu->items->toArray();

```

##### atau gunakan helper

```php
// Dengan Helper
$public_menu = Menu::getByName('Public'); //return array

```

### Menu Usage Example (b)

Sekarang di dalam file template blade Anda, letakkan menu menggunakan contoh sederhana ini

```php
<div class="nav-wrap">
    <div class="btn-menu">
        <span></span>
    </div><!-- //mobile menu button -->
    <nav id="mainnav" class="mainnav">

        @if($public_menu)
        <ul class="menu">
            @foreach($public_menu as $menu)
            <li class="">
                <a href="{{ $menu['link'] }}" title="">{{ $menu['label'] }}</a>
                @if( $menu['child'] )
                <ul class="sub-menu">
                    @foreach( $menu['child'] as $child )
                        <li class=""><a href="{{ $child['link'] }}" title="">{{ $child['label'] }}</a></li>
                    @endforeach
                </ul><!-- /.sub-menu -->
                @endif
            </li>
            @endforeach
        @endif

        </ul><!-- /.menu -->
    </nav><!-- /#mainnav -->
 </div><!-- /.nav-wrap -->
```

### HELPERS

### Ambil Menu Items By Menu ID

```php
use Erendi\Menu\Facades\Menu;
...
/*
Parameter: Menu ID
Return: Array
*/
$menuList = Menu::get(1);
```

### Ambil Menu Items By Menu Name

In this example, you must have a menu named _Admin_

```php
use Erendi\Menu\Facades\Menu;
...
/*
Parameter: Menu ID
Return: Array
*/
$menuList = Menu::getByName('Admin');
```

### Customization

Anda dapat mengedit antarmuka menu di **_resources/views/vendor/wmenu/menu-html.blade.php_**

### Credits

- [wmenu](https://github.com/lordmacu/wmenu) laravel package menu like wordpress (developer original)

### Compatibility

- Tested with laravel 5.2, 5.3, 5.4, 5.5, 5.6, 5.7, 5.8, 6.x, 7.x, 8.x
