<?php
namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Document;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Closure;

class DocumentTest extends TestCase
{
    public function testConteudoMaxLength()
    {
        $document = new Document();

        $content = str_repeat('A', $document->getMaxLength('contents') + 1);

        $validator = Validator::make([
            'category_id' => 1,
            'title' => 'Test Title',
            'contents' => $content,
        ], $document->rules());

        $this->assertTrue($validator->fails());
        $this->assertTrue($validator->errors()->has('contents'));
    }

    public function testCategoriaTituloRules()
    {
        $document = new Document();

        Validator::extend('contains_semestre', function ($attribute, $value, $parameters, $validator) {
            return stripos($value, 'semestre') !== false;
        });

        Validator::extend('contains_month', function ($attribute, $value, $parameters, $validator) {
            $months = [
                'Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho',
                'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'
            ];

            foreach ($months as $month) {
                if (stripos($value, $month) !== false) {
                    return true;
                }
            }

            return false;
        });


        // Testar categoria "Remessa" sem "semestre" no título
        $validator = Validator::make([
            'category_id' => 1,
            'title' => 'Test Title',
            'contents' => 'Test Contents',
        ], [
            'title' => [
                'required',
                'contains_semestre'
            ]
        ]);

        $this->assertTrue($validator->fails());
        $this->assertTrue($validator->errors()->has('title'));

        // Testar categoria "Remessa" com "semestre" no título
        $validator = Validator::make([
            'category_id' => 1,
            'title' => 'Test Title semestre',
            'contents' => 'Test Contents',
        ], [
            'title' => [
                'required',
                'contains_semestre'
            ]
        ]);

        $this->assertFalse($validator->fails());

        // Testar categoria "Remessa Parcial" sem nome de mês no título
        $validator = Validator::make([
            'category_id' => 2,
            'title' => 'Test Title',
            'contents' => 'Test Contents',
        ], [
            'title' => [
                'required',
                'contains_month'
            ]
        ]);

        $this->assertTrue($validator->fails());
        $this->assertTrue($validator->errors()->has('title'));

        // Testar categoria "Remessa Parcial" com nome de mês no título
        $validator = Validator::make([
            'category_id' => 2,
            'title' => 'Test Title Janeiro',
            'contents' => 'Test Contents',
        ], [
            'title' => [
                'required',
                'contains_month'
            ]
        ]);

        $this->assertFalse($validator->fails());
    }
}
