<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds for STEM Robotics Learning categories and subcategories.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            [
                'name' => 'Robótica y Mecatrónica',
                'description' => 'Construcción y diseño de estructuras robóticas, cinemática y actuadores mecánicos.',
                'icon_url' => 'https://cdn-icons-png.flaticon.com/512/2040/2040504.png',
                'subcategories' => [
                    ['name' => 'Sensores y Actuadores', 'description' => 'Integración de sensores infrarrojos, ultrasónicos y servomotores.'],
                    ['name' => 'Mecanismos y Engranajes', 'description' => 'Transmisión de potencia, relaciones de transmisión y chasis robóticos.'],
                    ['name' => 'Robots Móviles y Seguidores de Línea', 'description' => 'Navegación autónoma y seguimiento óptico en circuitos cerrados.'],
                ],
            ],
            [
                'name' => 'Programación y Algoritmia para Niños',
                'description' => 'Pensamiento computacional, lógica de bloques y primeros pasos en código para robótica.',
                'icon_url' => 'https://cdn-icons-png.flaticon.com/512/1005/1005141.png',
                'subcategories' => [
                    ['name' => 'Scratch y Programación Visual', 'description' => 'Animaciones interactivas y control de robots por bloques.'],
                    ['name' => 'Python para Microcontroladores', 'description' => 'Sintaxis básica y scripts para control de hardware interactivo.'],
                    ['name' => 'Lógica Computacional y Bucles', 'description' => 'Condicionales, secuencias y resolución de desafíos algorítmicos.'],
                ],
            ],
            [
                'name' => 'Electrónica y Microcontroladores',
                'description' => 'Fundamentos de circuitos, protoboards y microcontroladores educativos.',
                'icon_url' => 'https://cdn-icons-png.flaticon.com/512/2991/2991148.png',
                'subcategories' => [
                    ['name' => 'Circuitos Básicos y LEDs', 'description' => 'Leyes fundamentales, interruptores y circuitos de iluminación.'],
                    ['name' => 'Arduino para Escuelas', 'description' => 'Lectura analógica/digital y control de periféricos.'],
                    ['name' => 'Micro:bit y Dispositivos Vestibles', 'description' => 'Matriz de LEDs, acelerómetros y proyectos wearables.'],
                ],
            ],
            [
                'name' => 'Diseño e Impresión 3D',
                'description' => 'Modelado digital para piezas personalizadas y prototipos de ingeniería escolar.',
                'icon_url' => 'https://cdn-icons-png.flaticon.com/512/2888/2888704.png',
                'subcategories' => [
                    ['name' => 'Modelado Digital en Tinkercad', 'description' => 'Diseño volumétrico intuitivo de componentes robóticos.'],
                    ['name' => 'Prototipado Rápido y Piezas Mecánicas', 'description' => 'Optimización de ensamblajes para fabricación aditiva.'],
                ],
            ],
            [
                'name' => 'Inteligencia Artificial e IoT Escolar',
                'description' => 'Introducción interactiva a la visión por computador y automatización del entorno.',
                'icon_url' => 'https://cdn-icons-png.flaticon.com/512/8618/8618881.png',
                'subcategories' => [
                    ['name' => 'Visión Artificial para Robots', 'description' => 'Reconocimiento básico de colores, figuras y marcas visuales.'],
                    ['name' => 'Domótica y Automatización del Aula', 'description' => 'Dispositivos inteligentes conectados para ahorro energético y confort.'],
                ],
            ],
        ];

        foreach ($categories as $catData) {
            $category = Category::create([
                'name' => $catData['name'],
                'description' => $catData['description'],
                'icon_url' => $catData['icon_url'],
            ]);

            foreach ($catData['subcategories'] as $subcatData) {
                Subcategory::create([
                    'name' => $subcatData['name'],
                    'description' => $subcatData['description'],
                    'icon_url' => $catData['icon_url'],
                    'category_id' => $category->id,
                ]);
            }
        }
    }
}
