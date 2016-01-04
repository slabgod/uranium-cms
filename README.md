# Uranium CMS

Basic overview:

 * This is a very simple CMS that lets you edit static pages
 * Written in PHP, using MySQL for storage, Twig Template engine for the templates

# Usage

A typical setup flow:
* Clone into your web server directory
* Create the database cms in MySQL
* Add DB configuration into conn.php and add the directory of your templates to conf.php (default is just the root of templates)
* Put your template into your specified directory
* Go to /editor/
* Edit away!

You can hit save to update your DB, or you can hit publish to both update the DB and save the file to html in the root.

# Making a template

First off, in order for the editor to work you need to place ```{{ editor_head }}``` in your head and ```{{ editor_scripts }}``` right before the end of your body.

These are the basic elements as of right now

```html
A standard small text block (element can be anything)
<p id="e1" class="{{ editable }}" {{ content_editable }}>{{ data['e1']|default('Change me') }}</p>

A larger text block (must be a div)
<div id="e2" class="{{ editable }} {{ large_editor }}">{{ data['e2']|default('Change me') }}</div>

An image
<img class="{{ editable_image }}" id="img1" src="{{ data['img1']|default('bg.jpg') }}" alt="" />
```
For small text blocks set the content to ```{{ data['elementId']|default('Change me') }}``` and set the id of the element to ```id="elementId"```. Then add the class ```{{ editable }}``` and the property ```{{ content_editable }}```.

For large text blocks (these bring up a fancy editor when clicked on) use the same scheme, but instead of adding ```{{ content_editable }}``` add ```{{ large_editor }}``` to your classes, along with ```{{ editable }}```. You must also remember to set the content as ```{{ data['elementId'|default('Change me') }}``` and the id to ```id="elementId"```.

For images, just add the class ```{{ editable_image }}``` and set the ```src``` property to ```{{ data['elementId']|default('bg.jpg') }}``` and then set the id to ```id="elementId"```.

Any css or js that you would like to include would also need the ```{{ path }}``` tag at the beginning like so:
```html
<link rel="stylesheet" href="{{ path }}templates/striped/assets/css/main.css" />
```
So that it can be accessed both from the editor and the compiled html

A demo template is in the templates folder under the name index.html, enter the file name into the editor to bring it up. Click on any of the elements, and you will be able to edit them.

# To Do:
* **Add ability to change links, both text and href**
* **Add login (working on it right now)**
* **Add Twig using submodules instead of just including the code (in git)**
* Fix errors that show when there is no data yet
* Make the code not ugly/performance imporvements
* Consolidate css/js and make sure it doesn't conflict with page css


# LICENSE
This project is using the MIT License. Please see LICENSE to find out more.
