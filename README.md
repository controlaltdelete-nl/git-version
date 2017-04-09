[![Control Alt Delete.nl](images/ControlAltDelete-Github.png)](https://www.controlaltdelete.nl)

This package can be used to find the latest git tag. This can be used in various ways, IE for cache busting of your assets. It does not use exec, shell_exec, etc. It tries to read the files in your .git folder and retrieve the version from that.

# Installation

````
composer require controlaltdelete/git-version
````

# Usage

If the .git folder is the same folder as where the incoming request is made:
````
$version = \ControlAltDelete\GitVersion::find();
````

If the .git folder is somewhere else:
````
$version = \ControlAltDelete\GitVersion::find('path/to/.git/folder');
````
