<?php

use PHPUnit\Framework\TestCase;

#mdx:h autoload
require_once('vendor/autoload.php');

#mdx:h use
use FlSouto\HtButton;

/* 
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

*/

class HtButtonTest extends TestCase{


/* 
The below code simply creates and renders a button named "action". 
Notice that by default the button's label is its own name with the first letter in upper case:

#mdx:create

The above code will produce the following output:

#mdx:create -o

*/

	function testCreate(){
		#mdx:create
		$button = new HtButton("action");
		#/mdx echo $button
		$this->expectOutputRegex('/button.*Action.*button/');
		echo $button;
	}

/* 
### Specifing a label

The second parameter to the constructor accepts a label string:

#mdx:label -php

The output will be:

#mdx:label -o

*/
	function testCreateWithLabel(){
		#mdx:label
		$button = new HtButton("action", "Save");
		#/mdx echo $button
		$this->expectOutputRegex('/button.*Save.*button/');
		echo $button;
	}

/* 
#### Using the label setter

If you desire to set label after construction, use the label setter:

#mdx:labelset -php -h:autoload

Outputs:

#mdx:labelset -o

*/
	function testLabelSetter(){
		#mdx:labelset
		$button = new HtButton("action");
		$button->label("Save");
		#/mdx echo $button
		$this->expectOutputRegex('/button.*Save.*button/');
		echo $button;
	}

/* 
### Inline/Block Layout

By default the button is rendered in block mode, meaning that it will always appear in a new line.
In order to change it so that it is rendered in the same line, you have to call the `inline` method:

#mdx:inline -php -h:autoload,use

The output will be:

#mdx:inline -o

As you can see, it has simply added some css properties to the button's "style" attribute.

*/
	function testInlineTrue(){
		#mdx:inline
		$button = new HtButton("action");
		$button->inline(true);
		#/mdx echo $button
		$this->expectOutputRegex('/button.*style.*inline-block/');
		echo $button;
	}

/* 
Calling the same method with a `false` argument will return to the block layout:

#mdx:block idem

Output:

#mdx:block -o

*/
	function testInlineFalse(){
		#mdx:block
		$button = new HtButton("action");
		$button->inline(true);
		$button->inline(false);
		#/mdx echo $button
		$this->expectOutputRegex('/button.*style.*block/');
		echo $button;
	}

/* 
### Adding custom CSS

Pass an array to the `àttrs` method with a `style` key like in the example below:

#mdx:css idem

Outputs:
#mdx:css -o

*/

	function testInlineWithExtraStyling(){
		#mdx:css
		$button = new HtButton("action", "Delete");
		$button->attrs(['style'=>['background'=>'red','color'=>'yellow']]);
		#/mdx echo $button
		$this->expectOutputRegex('/button.*style.*inline-block.*red.*yellow/');
		echo $button;
	}
	
/* 
### Changing default value

The value that gets sent on a form submission event is by default a random string which
is the same as the button's id. So, if you want to change that, you have to change the id attribute:

#mdx:value idem

#mdx:value -o

*/

	function testChangeValue(){
		#mdx:value
		$button = new HtButton("action", "Delete");
		$button->attrs(['id'=>'delete']);
		#/mdx echo $button
		$this->expectOutputRegex('/button.*id.*delete.*value.*delete.*Delete/');
		echo $button;
	}

/*
### Checking if button has been pressed

If you nested your button inside a form, chances are you will need at some point
to check if that button has been pressed so you can process the requested action:

#mdx:check idem

Outputs:

```
Deleting...
```
*/
	function testCheckSubmit(){

		$this->expectOutputString('Deleting...');

		#mdx:check
		$_REQUEST['delete'] = 1; // pretend a form has been submitted

		$button = new HtButton('delete');
		$button->context($_REQUEST);

		if($button->value()){
			echo 'Deleting...';
		}
		#/mdx

	}

/*
### Handling multiple buttons

Sometimes you may want to have more than one action available in a form.
In this case you will probably need to have muliple buttons and be able
to tell which one has been clicked. The following snippet shows you how
to do just that:

#mdx:multi idem

The output will be:

```
Deleting...
```

*/

	function testMultipleButtons(){
		
		$this->expectOutputString('Deleting...');
		#mdx:multi
		$_REQUEST['action_delete'] = 1; // pretend a form has been submitted

		$updateBtn = (new HtButton('action_update'))->context($_REQUEST);
		$deleteBtn = (new HtButton('action_delete'))->context($_REQUEST);

		if($updateBtn->value()){
			echo 'Updating...';
		}

		if($deleteBtn->value()) {
			echo 'Deleting...';
		}
		#/mdx

	}

/* 
### Handling buttons with same name

I wouldn't recommend giving the same name to different buttons on the same form, but, since I've seen this pattern
been used by many developers I decided to include an example of how one could handle that problem through this API.
You basically have to give a different id/value to each button and check which one has been sent in a switch block:

#mdx:multisame idem

The output will be:

```
Updating...
```

*/

	function testMultipleButtonsWithSameName(){

		$this->expectOutputString('Updating...');
		#mdx:multisame
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
		#/mdx

	}

}