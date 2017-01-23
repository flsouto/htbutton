# HtButton

## Overview

This class allows you to easily create html form buttons in an object oriented way and comes with the following features:

- Setting attributes and styles with ease
- Shortcut for inline/block layout
- Checking for form submission

**Notice:** this class extends an abstract class called `HtField`. The inherited functionality will not be covered here. So, if you find difficulty in understanding something, please refer to [this](https://github.com/flsouto/htfield) documentation.

## Installation

Use composer:

```
composer require flsouto/htbutton
```

## Usage


The below code simply creates and renders a button named "action". 
Notice that by default the button's label is its own name with the first letter in upper case:

```php
<?php
require_once('vendor/autoload.php');
use FlSouto\HtButton;

$button = new HtButton("action");

echo $button;
```

The above code will produce the following output:

```
<button id="58854a02812ac" name="action" style="display:block" value="58854a02812ac">Action</button>
```


### Specifing a label

The second parameter to the constructor accepts a label string:

```php
require_once('vendor/autoload.php');
use FlSouto\HtButton;

$button = new HtButton("action", "Save");

echo $button;
```

The output will be:

```
<button id="58854a028153c" name="action" style="display:block" value="58854a028153c">Save</button>
```


#### Using the label setter

If you desire to set label after construction, use the label setter:

```php
use FlSouto\HtButton;

$button = new HtButton("action");
$button->label("Save");

echo $button;
```

Outputs:

```
<button id="58854a02816d6" name="action" style="display:block" value="58854a02816d6">Save</button>
```


### Inline/Block Layout

By default the button is rendered in block mode, meaning that it will always appear in a new line.
In order to change it so that it is rendered in the same line, you have to call the `inline` method:

```php

$button = new HtButton("action");
$button->inline(true);

echo $button;
```

The output will be:

```
<button id="58854a028188d" name="action" style="display:inline-block;vertical-align:text-top" value="58854a028188d">Action</button>
```

As you can see, it has simply added some css properties to the button's "style" attribute.


Calling the same method with a `false` argument will return to the block layout:

```php

$button = new HtButton("action");
$button->inline(true);
$button->inline(false);

echo $button;
```

Output:

```
<button id="58854a0281a2a" name="action" style="display:block;vertical-align:text-top" value="58854a0281a2a">Action</button>
```


### Adding custom CSS

Pass an array to the `àttrs` method with a `style` key like in the example below:

```php

$button = new HtButton("action", "Delete");
$button->attrs(['style'=>['background'=>'red','color'=>'yellow']]);

echo $button;
```

Outputs:
```
<button id="58854a0281bb7" name="action" style="display:block;background:red;color:yellow" value="58854a0281bb7">Delete</button>
```


### Changing default value

The value that gets sent on a form submission event is by default a random string which
is the same as the button's id. So, if you want to change that, you have to change the id attribute:

```php

$button = new HtButton("action", "Delete");
$button->attrs(['id'=>'delete']);

echo $button;
```

```
<button id="delete" name="action" style="display:block" value="delete">Delete</button>
```


### Checking if button has been pressed

If you nested your button inside a form, chances are you will need at some point
to check if that button has been pressed so you can process the requested action:

```php

$_REQUEST['delete'] = 1; // pretend a form has been submitted

$button = new HtButton('delete');
$button->context($_REQUEST);

if($button->value()){
	echo 'Deleting...';
}

```

Outputs:

```
Deleting...
```

### Handling multiple buttons

Sometimes you may want to have more than one action available in a form.
In this case you will probably need to have muliple buttons and be able
to tell which one has been clicked. The following snippet shows you how
to do just that:

```php

$_REQUEST['action_delete'] = 1; // pretend a form has been submitted

$updateBtn = (new HtButton('action_update'))->context($_REQUEST);
$deleteBtn = (new HtButton('action_delete'))->context($_REQUEST);

if($updateBtn->value()){
	echo 'Updating...';
}

if($deleteBtn->value()) {
	echo 'Deleting...';
}

```

The output will be:

```
Deleting...
```


### Handling buttons with same name

I wouldn't recommend giving the same name to different buttons on the same form, but, since I've seen this pattern
been used by many developers I decided to include an example of how one could handle that problem through this API.
You basically have to give a different id/value to each button and check which one has been sent in a switch block:

```php

$_REQUEST['action'] = 'update';

$updateBtn = new HtButton('action','Update');
$updateBtn->attrs(['id'=>'update'])->context($_REQUEST);

$deleteBtn = new HtButton('action','Delete');
$deleteBtn->attrs(['id'=>'delete'])->context($_REQUEST);

if(isset($_REQUEST['action'])){
	switch($_REQUEST['action']){
		case $updateBtn->id() :
			echo 'Updating...';
			break;
		case $deleteBtn->id() :
			echo 'Deleting...';
			break;
	}
}

```

The output will be:

```
Updating...
```
