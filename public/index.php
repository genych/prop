<!DOCTYPE html>

<form method="post">
	<input type="hidden" name="populate" value="1">
	<input type="submit" value="Populate DB">
</form>

<br><br>

<label for="search">Search:</label><br>
<form method="post" name="search">
	<input type="hidden" name="search" value="1">

	<label for="name">Name:</label><br>
	<input type="text" name="name" value=""><br>

	<label for="beds">Number of bedrooms:</label><br>
	<input type="number" name="beds" value=""><br>

	<label for="price">Price (less than):</label><br>
	<input type="number" name="price" value=""><br>

	<label for="type">Property type:</label><br>
	<input type="text" id="type" name="type" value=""><br>

	<input type="radio" name="sr" value="sale">
	<label for="sr">Sale</label><br>

	<input type="radio" name="sr" value="rent">
	<label for="sr">Rent</label><br><br>

	<input type="submit" value="Submit">
</form>

<br><br>
Results:
<br><br>
<!--lame but simple-->
<pre>

<?php

require __DIR__ . '/../src/controller.php';

use function Pr\Controller\controller;

var_export(controller($_REQUEST));
