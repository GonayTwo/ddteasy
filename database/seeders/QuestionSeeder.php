<?php

namespace Database\Seeders;

use App\Models\Faq\Question;
use Illuminate\Database\Seeder;

class QuestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Question::create([
            'title' => 'Quais produtos são utilizados na dedetização?',
            'text' => 'Hoje contamos com inúmeras fórmulas para dedetização, entre elas: líquidas, pó, micro-encapsulados, iscas e géis. Toda empresa especializada em dedetização deve utilizar somente produtos registrados e autorizados pela Vigilância Sanitária em ambientes específicos.',
            'sort' => 0,
        ]);
        Question::create([
            'title' => 'Qual produto para dedetização é recomendável para quem tem pet em casa?',
            'text' => 'Quando temos pets em nossa casa, aconselhamos a dedetização em GEL, mas caso seja necessária utilizarmos a aplicação com PULVERIZAÇÃO, é necessário retirar o seu pet por algumas horas.',
            'sort' => 0,
        ]);
        Question::create([
            'title' => 'Quais tipos de dedetização existem hoje?',
            'text' => 'Aplicação de Gel, Fumigação (Expurgo), Micropulverização UBV (Ultra Baixo Volume), Nebulização, Pincelamento, Pulverização líquida (spray)',
            'sort' => 0,
        ]);
        Question::create([
            'title' => 'O que é dedetização com massa e para qual situação é indicada?',
            'text' => 'Não existe mais a dedetização com MASSA. Esse tipo de produto foi substituído pelo GEL que são produtos autorizados pela ANVISA - Secretaria da Saúde, e recomendados para ambientes com riscos de contaminação ou circulação de pessoas, etc.',
            'sort' => 0,
        ]);
        Question::create([
            'title' => 'O que é controle de pragas',
            'text' => 'Controle de Pragas são ações realizadas por meios físicos, inseticidas ou biológicos em locais onde foram detectadas infestações de pragas. Podem ser de ação imediata ou preventivas. Os insetos sempre existiram tendo um papel benéfico na natureza, porém, o homem através de suas ações causou um desequilíbrio no meio ambiente ocorrendo um aumento de espécies dominantes e extinção de outras. O crescimento da população de insetos os transformou em pragas.',
            'sort' => 0,
        ]);
        Question::create([
            'title' => 'Pessoa idosa tem que sair do local que vai ser dedetizado? ',
            'text' => 'Se a dedetização recomendada for em Gel não é necessário deixar o local. Já a dedetização com Pulverização, o local deve ser desocupado por qualquer pessoa e pets por algumas horas. No caso de idosos recomenda-se o mínimo de 12 horas.',
            'sort' => 0,
        ]);
        Question::create([
            'title' => 'Quando é necessário que as pessoas saiam do local para realização da dedetização?',
            'text' => 'Em caso de dedetização à base de pulverização spray e grau de toxidade, recomendam-se algumas horas, portanto, deve ser analisado o grau de risco e a devida formulação do produto a ser utilizado.',
            'sort' => 0,
        ]);
        Question::create([
            'title' => 'Existe alguma restrição para pets, quando se faz uma dedetização?',
            'text' => 'Para cada tipo de dedetização é necessário que sejam tomadas algumas providências como por exemplo, retirar os animais por um período de 6 a 12 horas.',
            'sort' => 0,
        ]);
        Question::create([
            'title' => 'É perigoso dedetizar uma casa com uma criança recém nascida?',
            'text' => 'A dedetização em Gel não oferece nenhum risco ao recém-nascido. No caso da dedetização com Pulverização, é necessário desocupar o local por no mínimo 12 horas.',
            'sort' => 0,
        ]);
        Question::create([
            'title' => 'O produto químico é um só para eliminar todos os insetos?',
            'text' => 'Não. Existem vários tipos de produtos químicos, específicos para cada inseto.',
            'sort' => 0,
        ]);
        Question::create([
            'title' => 'Para residências é necessário realizar a dedetização de forma periódica? ',
            'text' => 'Sim! Ao passar do tempo, as limpezas domésticas vão enfraquecendo a eficácia dos produtos utilizados na dedetização e quando trazemos novos alimentos ou produtos adquiridos em supermercados, feiras, etc, existe a possibilidade de trazermos alguns insetos nessas embalagens.',
            'sort' => 0,
        ]);
        Question::create([
            'title' => 'Na dedetização contra barata e formiga é necessário retirar os mantimentos dos armários?',
            'text' => 'Para esses tipos de pragas utilizamos a dedetização em GEL, não sendo necessário retirar os mantimentos nem as roupas dos armários, exceto em casos de grande infestação.',
            'sort' => 0,
        ]);
        Question::create([
            'title' => 'Por que no verão vejo mais baratas?',
            'text' => 'No verão, por ser uma época mais quente, a reprodução e proliferação das pragas tende a ser maior.',
            'sort' => 0,
        ]);
        Question::create([
            'title' => 'Todas as baratas são iguais (da mesma espécie) e as menores são mais novas e as maiores mais velhas?',
            'text' => 'Existem mais de 5.000 espécies de baratas, mas nas cidades as mais comuns são as Baratas Americana e Germânica. A Barata Americana mede aproximadamente de 3 a 4 cm e vive em média 4 anos. Normalmente encontramos essas baratas em bueiros e áreas externas como garagens, ruas, etc. A Barata Germânica mede aproximadamente de 1 a 1,5 cm e vive em média 1 ano. Normalmente encontramos essas baratas em cozinhas, dispensas e áreas internas.',
            'sort' => 0,
        ]);
        Question::create([
            'title' => 'Na dedetização contra formigas é possível atingir a rainha do formigueiro?',
            'text' => 'Sim! Após a dedetização, as formigas operárias comem o produto utilizado, que fica no seu tubo digestivo sendo regurgitado dentro do formigueiro onde a rainha se alimenta e é contaminada com o produto.',
            'sort' => 0,
        ]);
        Question::create([
            'title' => 'Qual o risco que corremos com as formigas na cozinha?',
            'text' => 'As formigas andam em qualquer lugar, passam por cima de fezes, esgotos, ralos e ainda se alimentam de outros insetos como as baratas, carregando consigo vários tipos de bactérias, portanto, devemos evitar o máximo em ter formiguinhas na cozinha.',
            'sort' => 0,
        ]);
        Question::create([
            'title' => 'Como é feita a dedetização contra as aranhas?',
            'text' => 'A dedetização contra aranhas é feita através de pulverização de um produto totalmente sem odor nos locais preferidos das aranhas, como quinas de teto, paredes e atrás de alguns móveis.',
            'sort' => 0,
        ]);
    }
}
