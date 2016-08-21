<?php namespace App\Traits;

trait Sluggable {

    /**
     * Thumbnails types
     */
    public function getSluggable()
    {
        // Check for overriding
        if (property_exists(__CLASS__, 'sluggable'))
        {
            return $this->sluggable;
        }
        // Default slug field
        return array('title');
    }

    public function generate($string)
    {

        $table = array(
            'А'=>'A','а'=>'a',  'К'=>'K','к'=>'k',  'Ф'=>'F','ф'=>'f',      ' ' => '-', '/' => '-',
            'Б'=>'B','б'=>'b',  'Л'=>'L','л'=>'l',  'Х'=>'H','х'=>'h',      ',' => '-', '.' => '-',
            'В'=>'V','в'=>'v',  'М'=>'M','м'=>'m',  'Ц'=>'C','ц'=>'c',
            'Г'=>'G','г'=>'g',  'Н'=>'N','н'=>'n',  'Ч'=>'CH','ч'=>'ch',    '!' => '', '?' => '',
            'Д'=>'D','д'=>'d',  'О'=>'O','о'=>'o',  'Ш'=>'SH','ш'=>'sh',    '–' => '', '%' => '',
            'Е'=>'E','е'=>'e',  'П'=>'P','п'=>'p',  'Щ'=>'SHT', 'щ'=>'sht', '"' => '', '&quot;' => '',
            'Ж'=>'ZH','ж'=>'zh','Р'=>'R','р'=>'r',  'Ъ'=>'A','ъ'=>'a',
            'З'=>'Z','з'=>'z',  'С'=>'S','с'=>'s',  'Ь'=>'' ,'ь'=>'',
            'И'=>'I','и'=>'i',  'Т'=>'T','т'=>'t',  'Ю'=>'YU','ю'=>'yu',
            'Й'=>'Y','й'=>'y',  'У'=>'U','у'=>'u',  'Я'=>'YA','я'=>'ya',
        );

        // Replace from table
        $replaced = strtolower(strtr($string, $table));
        //Remove duplicated
        $slug = preg_replace('/-+/', '-', trim($replaced, '-'));
        //Remove duplicated spaces
        // $slug = preg_replace(array('/\s+/', '/[\t\n]/'), ' ', trim($slug, '-'));
        return $slug;
    }

    public function getSlug()
    {
        // Get configured slug
        $fields = $this->getSluggable();
        $slug = "";

        foreach ($fields as $field) {
            $slug .= $this->attributes[$field] . " ";
        }

        return $this->generate($slug);
    }

}
