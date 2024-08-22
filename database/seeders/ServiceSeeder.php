<?php

namespace Database\Seeders;

use App\Models\Services\Plague;
use App\Models\Services\Service;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $service = Service::create([
            'name' => 'Dedetização com Gel Inseticida',
            'slug' => \Illuminate\Support\Str::slug('Dedetização com Gel Inseticida'),
            'description' => 'A dedetização em gel é um método profissional seguro se aplicado por técnicos especializados. O tratamento proporciona maior tranquilidade porque além de não ser necessário nenhuma providência com relação ao ambiente você não precisa sair de casa. O gel é aplicado com uma "pistola aplicador" em locais estratégicos, eliminando a infestação e gerando uma barreira contra novas infestações.',
            'benefits' => [
                'Não precisa sair de casa',
                'Não tem cheiro',
                'Não mancha',
                'Não libera gases tóxicos',
                'É seguro para pessoas sensíveis e animais domésticos',
                'Tem alta eficiência',
                'Não há necessidade de remover móveis e demais objetos',
            ],
        ]);
        $service->plagues()->saveMany(Plague::whereIn('slug', ['baratas', 'formigas'])->get());

        $service = Service::create([
            'name' => 'Dedetização Spray (Pulverização)',
            'slug' => \Illuminate\Support\Str::slug('Dedetização Spray (Pulverização)'),
            'description' => 'A dedetização feita pelo método de aspersão/pulverização consiste na aplicação de produtos químicos, devidamente registrados pela ANVISA e próprio para aplicação em ambientes domiciliares, por intermédio de pulverizadores, manuais ou costais. Os produtos são escolhidos de acordo com a praga alvo, o inseticida aplicado tem um odor de nível fraco e grau tóxico reduzido, sendo bastante seguro se respeitado as recomendações do especialista.',
            'observations' => '<ul><li>Limpar a área um dia antes da realização do serviço, assim o local que receberá o procedimento estará livre de poeiras, o que garantirá uma maior fixação do produto de dedetização.</li><li>Afastar todos os móveis das paredes, a fim de facilitar a aplicação do spray.</li><li>Caso a aplicação seja feita nos armários, todos os alimentos devem ser retirados e armazenados em local seguro para não serem contaminados.</li><li>Deixe os Pets em locais seguros e, de preferência, longe da área que será dedetizada e aquários e gaiolas devem ser cobertos durante o procedimento.</li><li>Caso a dedetização seja para eliminação de traças, cupins e baratas, por exemplo, será necessário esvaziar o guarda-roupa para que os produtos sejam aplicados em todo o móvel.</li><li>Se puder, deixe as roupas e acessórios dentro de um saco plástico para protegê-los.</li></ul>',
            'benefits' => [
                'Efeito residual e desalojante (tem longa durabilidade no ambiente e obriga o inseto a abandonar o seu esconderijo)',
                'Efeito "Knockdown", elimina a praga de forma imediata',
                'Atinge uma gama maior de pragas',
            ],
        ]);
        $service->plagues()->saveMany(Plague::all());
    }
}
