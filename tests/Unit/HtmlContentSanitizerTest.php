<?php

namespace Tests\Unit;

use App\Services\HtmlContentSanitizer;
use PHPUnit\Framework\TestCase;

class HtmlContentSanitizerTest extends TestCase
{
    public function test_it_removes_executable_content_and_preserves_safe_markup(): void
    {
        $html = '<section class="content"><h2>Título</h2><script>alert(1)</script><a href="javascript:alert(1)" onclick="alert(1)">Enlace</a></section>';
        $clean = (new HtmlContentSanitizer)->sanitize($html);

        $this->assertStringContainsString('<section class="content">', $clean);
        $this->assertStringContainsString('<h2>Título</h2>', $clean);
        $this->assertStringNotContainsString('<script', $clean);
        $this->assertStringNotContainsString('javascript:', $clean);
        $this->assertStringNotContainsString('onclick', $clean);
    }
}
