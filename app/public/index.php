<?php
namespace App;
use PSR\Container\ContainerExceptionInterface;
class Programmer implements ContainerInterface
{
    /**
     * @param string $skills
     */
    private $skills;


    public function __construct($skills)
    {
        $this->skills = $skills;
    }

    public function totalSkills()
    {
        return count($this->skills);
    }
}

$createskills = ["PHP", "JQUERY", "AJAX"];
$p = new Programmer($createskills);
echo $p->totalSkills();