<?php
declare(strict_types=1);

namespace App\View\Helper;

use Cake\View\Helper;
use Cake\View\View;

/**
 * Htmltag helper
 */
class HtmltagHelper extends Helper
{
    /**
     * Default configuration.
     *
     * @var array
     */
    protected $_defaultConfig = [];

    function adapt($text)
    {
        // span
        $text = preg_replace('/&lt;(\s*)span(\s*)class=&quot;(.*?)&quot;&gt;/', '<span class="$3">' ,$text);
        $text = preg_replace('/&lt;(\s*)\/span(\s*)&gt;/', '</span>' ,$text);

        // ruby
        $text = preg_replace('/&lt;(\s*)ruby(\s*)&gt;/', '<ruby>' ,$text);
        $text = preg_replace('/&lt;(\s*)\/ruby(\s*)&gt;/', '</ruby>' ,$text);
        $text = preg_replace('/&lt;(\s*)rb(\s*)&gt;/', '<rb>' ,$text);
        $text = preg_replace('/&lt;(\s*)\/rb(\s*)&gt;/', '</rb>' ,$text);
        $text = preg_replace('/&lt;(\s*)rp(\s*)&gt;/', '<rp>' ,$text);
        $text = preg_replace('/&lt;(\s*)\/rp(\s*)&gt;/', '</rp>' ,$text);
        $text = preg_replace('/&lt;(\s*)rt(\s*)&gt;/', '<rt>' ,$text);
        $text = preg_replace('/&lt;(\s*)\/rt(\s*)&gt;/', '</rt>' ,$text);

        return $text;
    }

}
