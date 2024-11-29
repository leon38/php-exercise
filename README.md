
# Sample PHP classes generator
Given the following format of XML :

    <?xml version="1.0" encoding="utf-8"?>
    <classes>
	    <class id="Name_Of_The_Class">
				<parent>
					<class id="Name_Of_The_Parent_Class>
				</class>
	    </class>
    </classes>

*Where:*

The tag **classes** contains of collection of *one or more* **class** tags.

The attribute **id** of the **class** is the name of this class.

The **parent** tag is optional. If present it *must* contain the **class** tag with the attribute **id** defining the name of the parent class.

## Exercise 1
Create PHP program (to be launched from the command line) which takes as input the name of a XML file, reads the specified file and outputs the number of classes defined in the XML file.

When running your program against the provided **sample1.xml** file, the expected result is: 4. 

##  Exercise 2
Create PHP program (to be launched from the command line) which takes as input a XML file, reads the specified file and outputs a PHP file containing a valid PHP declaration of all the classes defined in the given XML file.

Run your program against the provided **sample1.xml** and check that the result is a valid PHP file.

### Example:

For example, the following XML:

     <?xml version="1.0" encoding="utf-8"?>
    <classes>
	    <class id="MyClass1">
	    </class>
	    <class id="MyClass2">
				<parent>
					<class id="MyClass1>
				</class>
	    </class>
    </classes>

Must produce the following PHP:

    <?php
    class MyClass1
    {
    }
    class MyClass2 extends MyClass1
    {
    }
   

