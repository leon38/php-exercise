<?php
namespace Damien\Combodo;

class XMLParser
{
    public ?\DOMDocument $document = null;
    public ?\DOMXPath $xpath = null;

    public function __construct(public string $filename)
    {
        $this->document = $this->fileToDOMDocument();
        $this->xpath = new \DOMXPath($this->document);
    }

    public function fileToDOMDocument(): \DOMDocument
    {
        $handle = fopen($this->filename, "r");
        $contents = fread($handle, filesize($this->filename));
        fclose($handle);
        $document = new \DOMDocument();
        $document->loadXML($contents);
        return $document;
    }

    public function parseItems(): void
    {
        /**
         * @var array<object{id:string, nodeName:string}> $items
         */
        $items = $this->xpath->query("//class[@id]");
        
        $fileStart = "<?php\n";
        $classDeclaration = '';
        $classes = [];
        foreach($items as $item) {
            if (isset($item->id)) {
                $currentClassName = $item->id;
                if (!isset($classes[$currentClassName]) || !$classes[$currentClassName]) {
                    $classDeclaration .= "class ".$currentClassName;
                    $classes[$currentClassName] = true;
                    
                    /**
                     * @var array<object{id:string, nodeName:string}> $childrenItems
                     */
                    $childrenItems = $this->xpath->query('//class[@id="'.$currentClassName.'"]/parent/class[@id]');
                    if (count($childrenItems) > 1) {
                        throw new \Exception("File is not formatted correctly, a class can only have one parent"); 
                    }
                    
                    if (count($childrenItems) === 1) {
                        if (!isset($classes[$childrenItems[0]->id])) {
                            throw new \Exception("The parent class is not declared");
                        }
            
                        $classDeclaration .= " extends ".$childrenItems[0]->id;    
                    }
                
                    $classDeclaration .= "\n{\n}\n";
                }
            }

        }
        $handleClass = fopen('output/classes.php', 'w');
        fwrite($handleClass, $fileStart.$classDeclaration);
        fclose($handleClass);
    }
}