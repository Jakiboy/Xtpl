# Xtpl (Ajax Template Transformer)
Xtpl is a tiny powerful HTML/Ajax rendering class for PHP >= 5.6 using shortcode system, Similar to Symfony renderView, but comes with new features.
Xtpl is a Bundle of FloatPHP Framework, works in FloatPHP projects, and also available for non-framework projects, and as a Symfony Bundle too.

# Which projects ?

Like Load more system, when fetching data from SQL request to HTML target, using jQuery append function.
For example, in place of (**Hardcoding**) building result HTML With PHP in Controller and return content, you can simply define shortcodes in target (**HTML Template**), then use Xtpl class to retrun rendered result content.

# For what ?

In this case, editing template w'll be simple because HTML template is separated from logical, and controller is quickly maintainable.
And in big term, Xtpl is dedicated for keeping clear MVC Pattern.

# How it works ?

The basic concept is on shortcodes and keys of result SQL arrays, the class transform shortcodes names to value of data with the same names of array keys, for example; in template the shortcode ```<span>{name}</span>``` is placed, and in SQL result Multi-dimensional Array **['name'=>'John']** etc, then rendered result should be ```<span>John</span>```.

# How to use ?

Basic usage :

```PHP
include('Xtpl.php'); // our class
$multiple; // Multi-dimensional Array of SQL result, (SELECT * FROM example)
$x = new Xtpl('template.tpl'); // instance with template path
echo $x->transformAll($multiple)->response; // return result for Ajax call
```

# What methods ?

**transformAll** :

Transform all shortcodes with entities (attributes), shortcodes replacements are defined automatically, shortcode Must be compatible with returned data, eg. if in data array an attribute is named **phone**, shortcode in template Must be **{phone}**, or you can customize shortcode with setDelimiter method.
transformAll method works onlly on multi-dimensional array, as an SQL response.

```PHP
echo $x->transformAll($multiple)->response;
```

**transform** :

transform method works on non multi-dimensional array as a single shifted array

```PHP
echo $x->transform($single)->response;
```

**setDelimiter** :

Customize shortcodes, or even use multiple shortcodes : [shortcode]

```PHP
$x->setDelimiter('[',']');
```

**shortcodeIn** :

Return boolean of shortcode existence on template,
Must use setDelimiter method to detect other shortcodes with different delimiters

```PHP
$x->shortcodeIn('{name}'); // return false|true
```

**clear** :

Clear non-replaced shortcodes, Must be used before response

```PHP
echo $x->transformAll($multiple)->clear()->response;
```

# Other Use case ?

**Usage for static method** :

```PHP
echo Xtpl::build('template.tpl')->transformAll($multiple)->response;
```

**Transform all with extra shortcode** :

```PHP
	$x->transformAll($multiple);
	$x->transform(['date'=>'22/10/2017']); // {date}
	echo $x->response;
```

**transform method on multi-dimensional array using loop** :

```PHP
	foreach($multiple as $single) {
	 $x->transform($single);
	}
	echo $x->response;
```

**Separated transform method on non multi-dimensional array** :

```PHP
	echo $x->transform(['id'  => '1'])
	       ->transform(['name' => 'john'])
	       ->transform(['mail' => 'john@mail.com'])
	       ->transform(['phone'=> '012345678'])
	       ->response;
```

**Both transform and transformAll on multi-dimensional array** :

```PHP
echo $x->transformAll($multiple)->transform($single)->response;
```
