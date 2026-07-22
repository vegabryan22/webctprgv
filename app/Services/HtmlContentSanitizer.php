<?php

namespace App\Services;

use DOMDocument;
use DOMElement;
use DOMXPath;

class HtmlContentSanitizer
{
    public function sanitize(?string $html): string
    {
        if (blank($html)) {
            return '';
        }

        $document = new DOMDocument('1.0', 'UTF-8');
        $previous = libxml_use_internal_errors(true);
        $document->loadHTML('<?xml encoding="UTF-8"><div id="cms-root">'.$html.'</div>', LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        libxml_clear_errors();
        libxml_use_internal_errors($previous);

        $xpath = new DOMXPath($document);
        foreach ($xpath->query('//script|//object|//embed|//base|//meta|//link') as $node) {
            $node->parentNode?->removeChild($node);
        }

        foreach ($xpath->query('//*') as $element) {
            if (! $element instanceof DOMElement) {
                continue;
            }

            foreach (iterator_to_array($element->attributes) as $attribute) {
                $name = strtolower($attribute->name);
                $value = trim($attribute->value);

                if (str_starts_with($name, 'on') || $name === 'srcdoc') {
                    $element->removeAttribute($attribute->name);

                    continue;
                }

                if (in_array($name, ['href', 'src'], true) && preg_match('/^\s*(javascript|vbscript|data):/i', $value)) {
                    $element->removeAttribute($attribute->name);
                }
            }

            if ($element->tagName === 'iframe' && ! str_starts_with((string) $element->getAttribute('src'), 'https://www.youtube.com/embed/')) {
                $element->parentNode?->removeChild($element);
            }
        }

        $root = $document->getElementById('cms-root');
        $output = '';
        foreach (iterator_to_array($root?->childNodes ?? []) as $child) {
            $output .= $document->saveHTML($child);
        }

        return $output;
    }
}
