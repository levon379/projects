<?php namespace App\Traits;

trait Sluggable {

    /**
     * Default slug column
     * @var string
     */
    protected $slug = 'slug';

    /**
     * @override Model explicit binding to slug column
     */
    // public function getRouteKeyName()
    // {
    //     return $this->slug;
    // }

    /**
     * @return array | default sluggable column
     */
    public function sluggables()
    {
        // Check for overriding
        if (property_exists(__CLASS__, 'sluggables') && is_array($this->sluggables))
        {
            return $this->sluggable;
        }
        // Default slug field
        return array('title','name');
    }

    /**
     * @return string Correct Cyrillic Transliterate
     */
    public function transliterate($string)
    {
        $table = array(
            'А'=>'A', 'а'=>'a',  'К'=>'K', 'к'=>'k',  'Ф'=>'F', 'ф'=>'f',
            'Б'=>'B', 'б'=>'b',  'Л'=>'L', 'л'=>'l',  'Х'=>'H', 'х'=>'h',
            'В'=>'V', 'в'=>'v',  'М'=>'M', 'м'=>'m',  'Ц'=>'C', 'ц'=>'c',
            'Г'=>'G', 'г'=>'g',  'Н'=>'N', 'н'=>'n',  'Ч'=>'CH', 'ч'=>'ch',
            'Д'=>'D', 'д'=>'d',  'О'=>'O', 'о'=>'o',  'Ш'=>'SH', 'ш'=>'sh',
            'Е'=>'E', 'е'=>'e',  'П'=>'P', 'п'=>'p',  'Щ'=>'SHT', 'щ'=>'sht',
            'Ж'=>'ZH', 'ж'=>'zh', 'Р'=>'R', 'р'=>'r',  'Ъ'=>'A', 'ъ'=>'a',
            'З'=>'Z', 'з'=>'z',  'С'=>'S', 'с'=>'s',  'Ь'=>'' , 'ь'=>'',
            'И'=>'I', 'и'=>'i',  'Т'=>'T', 'т'=>'t',  'Ю'=>'YU', 'ю'=>'yu',
            'Й'=>'Y', 'й'=>'y',  'У'=>'U', 'у'=>'u',  'Я'=>'YA', 'я'=>'ya',
        );

        return strtr($string, $table);
    }

    /**
     * Generate slug
     * @return void
     */
    public function makeSlug()
    {
        // Get sluggables fields
        $fields = $this->sluggables();

        $output = '';
        foreach ($fields as $field) {
            $output .= $this->attributes[$field] . '-';
        }

        $this->attributes[$this->getRouteKeyName()] = str_slug($this->transliterate($output), '-');
    }


    public function slug()
    {
        $fields = $this->sluggables();

        $output = '';
        foreach ($fields as $field) {
            if (!empty($this->attributes[$field]))
            {
                $output .= $this->attributes[$field] . '-';
            }
        }

        return str_slug($this->transliterate($output), '-');
    }

}
