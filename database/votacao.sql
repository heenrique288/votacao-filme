-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3307
-- Tempo de geração: 21/10/2025 às 05:48
-- Versão do servidor: 10.4.32-MariaDB
-- Versão do PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `votacao`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `filmes`
--

CREATE TABLE `filmes` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) DEFAULT NULL,
  `titulo` varchar(100) DEFAULT NULL,
  `sinopse` text DEFAULT NULL,
  `banner` varchar(255) DEFAULT NULL,
  `ano` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `filmes`
--

INSERT INTO `filmes` (`id`, `usuario_id`, `titulo`, `sinopse`, `banner`, `ano`) VALUES
(1, 1, 'A lista de Schindler', 'O alemão Oskar Schindler viu na mão de obra judia uma solução barata e viável para lucrar com negócios durante a guerra. Com sua forte influência dentro do partido nazista, foi fácil conseguir as autorizações e abrir uma fábrica. O que poderia parecer uma atitude de um homem não muito bondoso, transformou-se em um dos maiores casos de amor à vida da História, pois este alemão abdicou de toda sua fortuna para salvar a vida de mais de mil judeus em plena luta contra o extermínio alemão.', 'https://image.tmdb.org/t/p/w500/fvPYwfXH513e8Nqe0kzWFm2jjg.jpg', NULL),
(2, 1, 'Halloween', 'Na noite de Halloween de 1963, Michael Myers, de seis anos, assassina brutalmente sua irmã. Preso em uma instituição para doentes mentais sob os cuidados do dr. Sam Loomis, Michael cresce apenas para odiar. Em outubro de 1978, ele foge do hospital, seguido pelo dr. Loomis, que sabe que Michael vai matar novamente. O psicopata passa a perseguir a adolescente Laurie Strode e seus amigos, e prepara seu ataque mortal para a noite de Halloween.', 'https://image.tmdb.org/t/p/w500/mVQ8Lb7FhQXPqkQv0QCNbEwp9a6.jpg', NULL),
(3, 1, 'The Pianist', 'Um grande maestro passa a se recordar dos momentos difíceis de sua infância, relembrando de sua vida e seus traumas de quando vivia com seus Pais, do qual um Pai agressivo e uma mãe vítima acabam o criando em meio a brigas onde na música, por coincidência, encontra seu propósito.', 'https://image.tmdb.org/t/p/w500/bLAt2i9YGQaHibQPhHfJ3xFa5Gr.jpg', NULL),
(4, 1, 'Donnie Darko', 'Quem vê Donnie Darko logo imagina se tratar de um adolescente desajustado. Na verdade, Donnie está à beira da loucura, devido a visões constantes de um coelho monstruoso, que tenta mantê-lo sob a sua sinistra influência. Incitado pela aparição, Donnie tem atuação antissocial, enquanto se submete à terapia, sobrevive às extravagâncias da vida e do romance no colégio e, por acaso, escapa a uma estranha morte devido à queda de um avião. Donnie luta contra os seus demônios, literal e figurativamente, numa intriga de histórias entrelaçadas que jogam com as viagens no tempo, gurus fundamentalistas, predestinação e os desígnios do universo.', 'https://image.tmdb.org/t/p/w500/fhQoQfejY1hUcwyuLgpBrYs6uFt.jpg', NULL),
(5, 1, '墮落天使', 'Quando um veterano da Guerra do Iraque recebe um chamado de um poder superior, ele embarca em uma missão para impedir que um anjo caído levante um exército de mortos para dominar o mundo.', 'https://image.tmdb.org/t/p/w500/shlh2HrFhSlQj7wGoiesrEtk1px.jpg', NULL),
(6, 1, '生きる', 'Este documentário acompanha o dia a dia de pessoas cegas e surdas, pessoas surdocegas que vivem sozinhas na Ilha Sado, na província de Niigata. Um homem na cidade de Ishinomaki, província de Miyagi, que escolheu viver em sua comunidade apesar do terremoto e do tsunami, um jovem em Hiroshima que quer ser independente para poder se casar e continuar praticando judô, o professor Satoshi Fukushima, do Centro de Pesquisa para Ciência e Tecnologia Avançada da Universidade de Tóquio, que se tornou a primeira pessoa surda-cega a lecionar em tempo integral em uma universidade no mundo.', 'https://image.tmdb.org/t/p/w500/1OjF1vjhLIdx9abi3KCImDBl04Q.jpg', NULL),
(7, 1, 'Filhos da Esperança', 'No ano de 2027, a infertilidade é uma ameaça real para a civilização, e o último humano a nascer em anos acaba de morrer. Frente a um cenário pessimista sobre o futuro, um burocrata desiludido se torna o herói improvável que pode salvar a humanidade. Para isso, ele enfrenta seus próprios demônios e tenta proteger a última esperança do planeta: uma jovem mulher milagrosamente grávida, descoberta pela ativista inteligente com quem fora casado.', 'https://image.tmdb.org/t/p/w500/83qNeC3vHskUDseh78odYAynI6w.jpg', NULL),
(8, 1, 'O homem de palha', 'O Sgt. Howie investiga o desaparecimento de uma criança na ilha escocesa de Summerisle. Um cristão conservador, ele fica incomodado com os rituais pagãos e o comportamento sexual dos moradores, principalmente de Willow, filha do magistrado. Sua investigação mergulha nos costumes peculiares da ilha.', 'https://image.tmdb.org/t/p/w500/2eDub2VaMdy8mntxwGTE63g388q.jpg', NULL),
(9, 2, '올드보이', 'Um arrogante executivo, Joe Ducett, é sequestrado e passa 20 anos em cativeiro, sem saber quem o sequestrou ou o motivo. Enquanto isso, ele descobre, pela televisão, que sua ex-esposa foi assassinada e que ele é o principal suspeito. Certo dia, Joe é libertado e, com a ajuda de uma assistente social, ele tem apenas três dias para descobrir a verdade sobre seu sequestro.', 'https://image.tmdb.org/t/p/w500/ztQx1u8Vif626VOqavJAqgLlKNQ.jpg', NULL),
(10, 2, 'A grande aposta', 'Em 2008, o guru de Wall Street Michael Burry percebe que uma série de empréstimos feitos para o mercado imobiliário está em risco de inadimplência. Ele decide então apostar contra o mercado investindo mais de um bilhão de dólares dos seus investidores. Suas ações atraem a atenção do corretor Jared Vennet que percebe a oportunidade e passa a oferecê-la a seus clientes. Juntos, esses homens fazem uma fortuna tirando proveito do colapso econômico americano.', 'https://image.tmdb.org/t/p/w500/ef0fKJs8QdVF3Epxfa9EN33iD8Z.jpg', NULL),
(11, 2, 'Retrato de uma jovem em chamas', 'França, 1760. Marianne é contratada para pintar o retrato de casamento de Héloïse, uma jovem mulher que acabou de deixar o convento. Por ela ser uma noiva relutante, Marianne chega sob o disfarce de companhia, observando Héloïse de dia e a pintando secretamente à noite. Conforme as duas mulheres se aproximam, a intimidade e a atração crescem, enquanto compartilham os primeiros e últimos momentos de liberdade de Héloïse, antes do casamento iminente. O retrato de Héloïse logo se torna um ato colaborativo e o testamento do amor delas.', 'https://image.tmdb.org/t/p/w500/c3OkDxs7PQuLB12qiwZUDg7ZMO6.jpg', NULL),
(12, 2, 'Magnatas do Crime', 'Um talentoso graduado estadunidense em Oxford, usando suas habilidades únicas, audácia e propensão à violência, cria um império da maconha usando as propriedades dos aristocratas ingleses empobrecidos. No entanto, quando ele tenta vender seu negócio a um colega bilionário. Daí, uma cadeia de eventos se desenrola, envolvendo chantagem, decepção, caos e assassinato entre bandidos de rua, oligarcas russos, gângsteres e jornalistas.', 'https://image.tmdb.org/t/p/w500/vaeQ0Xersj2y5t1Hkqljb9i8RaU.jpg', NULL),
(13, 2, 'Bebê de Rosemary', 'Um jovem casal se muda para um apartamento em Nova York para começar uma família. As coisas ficam assustadoras quando Rosemary começa a suspeitar que seu futuro bebê não está seguro ao lado dos seus estranhos vizinhos.', 'https://image.tmdb.org/t/p/w500/4p8ljwqw0SJjKszU0ZSPTjYFbeR.jpg', NULL),
(14, 2, 'A vida é bela', 'Durante a Segunda Guerra Mundial na Itália, o judeu Guido e seu filho Giosué são levados para um campo de concentração nazista. Afastado da mulher, ele tem que usar sua imaginação para fazer o menino acreditar que estão participando de uma grande brincadeira, com o intuito de protegê-lo do terror e da violência que os cercam.', 'https://image.tmdb.org/t/p/w500/mdqU2CHabmbdkWKs1IvCfksbtNM.jpg', NULL),
(15, 3, 'Psicose', 'Marion Crane é uma secretária que rouba 40 mil dólares da imobiliária onde trabalha para se casar e começar uma nova vida. Durante a fuga à carro, ela enfrenta uma forte tempestade, erra o caminho e chega em um velho hotel. O estabelecimento é administrado por um sujeito atencioso chamado Norman Bates, que nutre um forte respeito e temor por sua mãe. Marion decide passar a noite no local, sem saber o perigo que a cerca.', 'https://image.tmdb.org/t/p/w500/oC2iYT2on8c2iZnehah1l6AWqGu.jpg', NULL),
(16, 3, 'Paris, Texas', 'Um homem sai do deserto sem lembranças de sua vida passada e é apenas com a ajuda de seu irmão que ele percebe que abandonou sua esposa e seu filho quatro anos antes.', 'https://image.tmdb.org/t/p/w500/i9CQ0biql97FgyICpQ5uIwbh7GE.jpg', NULL),
(17, 3, 'Persona', 'Uma atriz teatral de sucesso sofre uma crise emocional e para de falar. Uma enfermeira é designada a cuidar dela em uma casa reclusa, perto da praia, onde as duas permanecem sozinhas. Para quebrar o silêncio, a enfermeira começa a falar incessantemente, narrando diversos episódios relevantes de sua vida, mas quando descobre que a atriz usa seus depoimentos como fonte de análise, a cumplicidade entre as duas se transforma em embate.', 'https://image.tmdb.org/t/p/w500/pMlIFOHnNDa3X0kSpjASn75KAYd.jpg', NULL),
(18, 3, 'Akira', 'Uma grande explosão fez com que Tóquio fosse destruída em 1988. Em seu lugar, foi construída Neo-Tóquio, que, em 2019, sofre com atentados terroristas por toda a cidade. Kaneda e Tetsuo são amigos que integram uma gangue de motoqueiros. Eles disputam rachas violentos com uma gangue rival, os Palhaços, até que um dia, Tetsuo encontra Takashi, uma estranha criança com poderes que fugiu do hospital onde era mantido como cobaia. Tetsuo é ferido no encontro e, antes de receber a ajuda dos amigos, é levado por integrantes do exército, liderados pelo coronel Shikishima. A partir de então, Tetsuo passa a desenvolver poderes inimagináveis, o que faz com que seja comparado ao lendário Akira, responsável pela explosão de 1988. Paralelamente, Kaneda se interessa por Kei, uma garota envolvida com espiões, que tenta decifrar o enigma por trás das cobaias controladas pelo exército.', 'https://image.tmdb.org/t/p/w500/tbwwTQ3EqSdotbQ3ZcIl6vKBv7q.jpg', NULL),
(19, 3, 'A vida de Brian', 'A produção é uma sátira aos filmes bíblicos e à intolerância religiosa. Na Palestina do ano 1 d.C., três reis magos trazem presentes à mãe de Brian, confundindo-o com Jesus que nasceu no mesmo dia, na manjedoura ao lado. Brian, depois de crescido, engaja-se em um dos muitos grupos revolucionários que se opõem ao domínio romano. Após tentar seqüestrar a mulher de Pôncio Pilatos com seu grupo, ele é visto como Messias pela uma multidão, ávida por lideranças religiosas.', 'https://image.tmdb.org/t/p/w500/2zg9mTQqvf2Qava6KDzISVyZrPr.jpg', NULL),
(20, 4, 'The Usual Suspects', 'Depois que sua filha de seis anos e uma amiga dela são sequestradas, Keller Dove, um carpinteiro de Boston, enfrenta o departamento de polícia e o jovem detetive encarregado do caso para fazer justiça com as próprias mãos.', 'https://image.tmdb.org/t/p/w500/30YtzPOimO7eG30r8K8rUkqTGNj.jpg', NULL),
(21, 4, '12 Homens e uma sentença', 'Um jovem porto-riquenho é acusado do brutal crime de ter matado o próprio pai. Quando ele vai a julgamento, doze jurados se reúnem para decidir a sentença, levando em conta que o réu deve ser considerado inocente até que se prove o contrário. Onze dos jurados têm plena certeza de que ele é culpado, e votam pela condenação, mas um jurado acha que é melhor investigar mais para que a sentença seja correta. Para isso ele terá que enfrentar diferentes interpretações dos fatos, e a má vontade dos outros jurados, que só querem ir logo para suas casas.', 'https://image.tmdb.org/t/p/w500/q8RGf4SbVCObCySZ4PIGsn5wFm6.jpg', NULL),
(22, 4, 'Por um punhado de dólares', 'Joe é um pistoleiro barra pesada que chega a uma cidade que está em guerra. Quando percebem o potencial de Joe, ambas as partes se interessam por contratá-lo; é quando ele percebe que pode ganhar um dinheiro com a situação aceitando a proposta dos dois lados.', 'https://image.tmdb.org/t/p/w500/6lYT4Waw7Z9bgvNUZsMdLJ4ndCm.jpg', NULL),
(23, 4, 'Princesa Mononoke', 'Um príncipe infectado por uma doença sabe que irá morrer, a menos que encontre a cura. Sendo a sua última esperança, segue para o leste e, durante o caminho, encontra animais da floresta lutando contra a sua exploração, liderados pela princesa Mononoke.', 'https://image.tmdb.org/t/p/w500/7EadOwHmyQgOnlghRiWBygNtnjl.jpg', NULL),
(24, 5, 'Perfect Blue', 'Mima Kirigoe é membro de uma banda de música pop japonesa (J-Pop), chamada \"CHAM!\", que decide deixar a banda para se dedicar à carreira de atriz. Alguns fãs ficam descontentes com a repentina mudança de carreira, pois Mima, sendo um ídolo pop, é vista como uma menina inocente e angelical. Conforme avança em sua nova carreira, Mima mergulha em um intenso drama psicológico no qual fantasia e realidade se confundem colocando em dúvida sua ética moral.', 'https://image.tmdb.org/t/p/w500/6WTiOCfDPP8XV4jqfloiVWf7KHq.jpg', NULL),
(25, 5, 'Corra que a polícia vem aí', 'Apenas um homem tem as habilidades necessárias para liderar o Esquadrão Policial e salvar o mundo.', 'https://image.tmdb.org/t/p/w500/b84ieQvr9hG7E8rdvQCtk2P8hhF.jpg', NULL),
(26, 5, 'Os espartalhões', 'Os mesmo criadores de \"Deu a Louca em Hollywood\" e da série \"Todo Mundo em Pânico\" voltam com mais uma comédia paródica, agora tendo como fonte principal das piadas o épico \"300\". Xerxes, por exemplo, que no original era o sarado Rodrigo Santoro, aqui é o pançudo Ken Davitian (o companheiro de viagem de Borat). Além de \"300\", no entanto, a história arruma espaço para brincar com outros títulos conhecidos, como a série de TV \"O Aprendiz\" e os filmes \"Pequena Miss Sunshine\", \"Homem-Aranha 3\" e \"Happy Feet\".', 'https://image.tmdb.org/t/p/w500/3wvTTv6J4R53kGKP1Tj6IMcxnl.jpg', NULL),
(27, 5, '10 coisas que eu odeio em você', 'Em seu primeiro dia na nova escola, Cameron se apaixona por Bianca. Mas ela só poderá sair com rapazes até que Kat, sua irmã mais velha, arrume um namorado. O problema é que ela é insuportável. Cameron, então, negocia com o único garoto que talvez consiga sair com Kat – um misterioso bad-boy com uma péssima reputação.', 'https://image.tmdb.org/t/p/w500/sSr6OheCylo2rlt4Ko9OWwcmu3n.jpg', NULL),
(28, 6, 'Flores do Oriente', 'Em 1937, Nanquim encontra-se na frente de batalha entre China e Japão. Enquanto o exército imperial japonês invade a capital da China, os habitantes desesperados procuram refúgio atrás dos muros de uma catedral ocidental. Ali, John Miller (Christian Bale), um americano preso no meio do caos da batalha e da ocupação que se segue abriga-se, seguido por um grupo de estudantes inocentes e quatorze prostitutas, igualmente determinadas a fugir dos horrores que ocorrem do lado de fora da catedral. Lutando para sobreviver à violência e perseguição do exército japonês, um ato de heroísmo acaba levando um grupo aparentemente discrepante, a arriscar suas vidas pelo bem de todos.', 'https://image.tmdb.org/t/p/w500/6OBhpnPcL7kHX8KW8l5n603TNbC.jpg', NULL),
(29, 6, '28 Days Later', 'Já se passaram quase três décadas desde que o vírus da raiva escapou de um laboratório de armas biológicas. Agora, sob uma quarentena rigidamente imposta, alguns conseguiram encontrar maneiras de sobreviver em meio aos infectados. Um desses grupos vive em uma pequena ilha, ligada ao continente por uma única passagem fortemente protegida. Quando um dos membros parte em uma missão rumo ao sombrio coração do continente, ele descobre segredos, maravilhas e horrores que transformaram não apenas os infectados, mas também outros sobreviventes.', 'https://image.tmdb.org/t/p/w500/rN1G5YsRS5pzCx3hdkEBN8NKn2R.jpg', NULL),
(30, 6, 'Scarface', 'Após receber residência permanente nos Estados Unidos em troca do assassinato de um oficial do governo cubano, Tony Montana se torna o chefe do tráfico de drogas em Miami. Matando qualquer um que entre em seu caminho, Tony eventualmente se torna o maior traficante da Flórida, controlando quase toda a cocaína que entra em Miami. Porém, a pressão da polícia, as guerras com cartéis colombianos e sua própria paranoia servem para alimentar as chamas de sua eventual queda.', 'https://image.tmdb.org/t/p/w500/4d6ksr4wsBd1fifF7YLAm9wbWiK.jpg', NULL),
(31, 6, 'Sound of Metal', 'Um jovem baterista teme por seu futuro quando percebe que está gradualmente ficando surdo. Duas paixões estão em jogo: a música e sua namorada, que é integrante da mesma banda de heavy metal. Essa mudança drástica acarreta em muita tensão e angústia na vida do baterista, atormentado lentamente pelo silêncio.', 'https://image.tmdb.org/t/p/w500/cUXth1ZIyKLORMShHI9PNQTs135.jpg', NULL),
(32, 7, 'Manchester by the Sea', 'Lee Chandler, zelador de prédios em Boston, Massachusetts, é forçado a retornar a sua cidade natal, Manchester na Inglaterra, para assumir a guarda de seu sobrinho adolescente Patrick após o pai do rapaz, seu irmão Joe, falecer precocemente. Este retorno ficará ainda mais complicado quando Lee precisar enfrentar as razões que o fizeram ir embora e deixar sua família para trás, anos antes.', 'https://image.tmdb.org/t/p/w500/cc1pBNEv3YsmpAWhgF7TJhN8a4w.jpg', NULL),
(33, 7, 'Carrie, A Estranha', 'A quieta e sensível adolescente Carrie White enfrenta insultos dos colegas na escola e abuso em casa de sua mãe, uma fanática religiosa. Quando estranhos acontecimentos começam a acontecer em torno de Carrie, ela começa a suspeitar que tem poderes sobrenaturais.', 'https://image.tmdb.org/t/p/w500/bDgI10ARAA8xgeIOtEnQpYeYymA.jpg', 1976),
(34, 9, 'Um Lobisomem Americano em Londres', NULL, NULL, NULL),
(37, 4, 'Ne zha', NULL, NULL, 2019),
(38, 2, 'Silent Hill', NULL, NULL, NULL),
(39, 5, '500 dias com ela', NULL, NULL, NULL),
(40, 2, 'O Grande Lebowski', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estrutura para tabela `filme_semana`
--

CREATE TABLE `filme_semana` (
  `id` int(11) NOT NULL,
  `indicacao_id` int(11) NOT NULL,
  `titulo` varchar(255) DEFAULT NULL,
  `poster_path` varchar(255) DEFAULT NULL,
  `criado_em` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `indicacoes`
--

CREATE TABLE `indicacoes` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `filme_id` int(11) NOT NULL,
  `titulo` varchar(255) NOT NULL,
  `poster_path` varchar(255) DEFAULT NULL,
  `backdrop_path` varchar(255) DEFAULT NULL,
  `overview` text DEFAULT NULL,
  `data_indicacao` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `indicacoes`
--

INSERT INTO `indicacoes` (`id`, `usuario_id`, `filme_id`, `titulo`, `poster_path`, `backdrop_path`, `overview`, `data_indicacao`) VALUES
(6, 3, 299534, 'Vingadores: Ultimato', '/7jvlqGsxeMKscskuUZgKk0Kuv99.jpg', '/7RyHsO4yDXtBv1zUU3mTpHeQ0d5.jpg', 'Após os eventos devastadores de \"Vingadores: Guerra Infinita\", o universo está em ruínas devido aos esforços do Titã Louco, Thanos. Com a ajuda de aliados remanescentes, os Vingadores devem se reunir mais uma vez a fim de desfazer as ações de Thanos e restaurar a ordem no universo de uma vez por todas, não importando as consequências.', '2025-09-23 07:30:34'),
(7, 7, 1038392, 'Invocação do Mal 4: O Último Ritual', '/40nHGUfypLhlr7gJx8At1IbYkaK.jpg', '/fq8gLtrz1ByW3KQ2IM3RMZEIjsQ.jpg', 'Neste último capítulo, os Warren enfrentam mais um caso aterrorizante, desta vez envolvendo entidades misteriosas que desafiam sua experiência. Ed (Patrick Wilson) e Lorraine (Vera Farmiga) se veem obrigados a encarar seus maiores medos, colocando suas vidas em risco em uma batalha final contra forças malignas.', '2025-09-25 04:00:34'),
(8, 8, 814, 'Um Lobisomem Americano em Londres', '/gKvCDhPcykUyUILZqf78eN0skE8.jpg', '/4js6VLf6qHWUbW42BpXiQKPBP7t.jpg', 'Os americanos David e Jack viajam de mochila às costas pela Grã-Bretanha quando são atacados por um lobo. David sobrevive com uma mordida, mas Jack não resiste. Enquanto se recupera no hospital, David é atormentado por pesadelos com seu amigo mutilado, que o avisa que ele está virando um lobisomem.', '2025-09-25 04:22:17'),
(9, 9, 615453, 'Ne Zha', '/zb8xejiaNR0snSJgDepwFQUIi2e.jpg', '/k1pJslKr4aDayw9kWwWnlC3MIP3.jpg', '\"Ne Zha\" conta a história de um jovem prodígio, nascido como um demônio e destinado a trazer destruição, que luta contra o seu destino para se tornar um herói.  Ele nasce da união de uma pérola celestial e um coração de um demônio, amaldiçoado a trazer destruição ao mundo.  Por causa da sua origem demoníaca, Ne Zha é odiado e temido por todos, sendo forçado a lutar contra os seus próprios demônios interiores para provar o seu valor e mudar o seu destino. O filme acompanha a sua jornada enquanto ele tenta quebrar os grilhões do seu destino, escolhendo o bem em vez do mal para se tornar o herói que ele quer ser.', '2025-09-25 04:23:05'),
(14, 1, 671, 'Harry Potter e a Pedra Filosofal', '/4rtsbE9aQ1qw4gv7yYwaNYfWFoS.jpg', '/bfh9Z3Ghz4FOJAfLOAhmc3ccnHU.jpg', 'Harry Potter é um garoto órfão que vive infeliz com seus tios, os Dursley. Em seu aniversário de 11 anos ele recebe uma carta que mudará sua vida: um convite para ingressar em Hogwarts.', '2025-10-21 03:37:21');

-- --------------------------------------------------------

--
-- Estrutura para tabela `login`
--

CREATE TABLE `login` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `sobrenome` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `criado_em` timestamp NOT NULL DEFAULT current_timestamp(),
  `foto` varchar(255) DEFAULT NULL,
  `admin` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `login`
--

INSERT INTO `login` (`id`, `nome`, `sobrenome`, `email`, `senha`, `criado_em`, `foto`, `admin`) VALUES
(1, 'Henrique', 'José', 'henrique@gmail.com', '$2y$10$wSDqZE0Sc3TBuEJ4ZYPBl.U4wg24a3E.hrj7riRTBphI9rZXd4LFy', '2025-09-22 20:33:50', 'user_1.jpeg', 1),
(3, 'Fernando', 'José', 'f@gmail.com', '$2y$10$pxd.OPoxTO8s6hWxGMP8GumJ5bELLfjJAPwLUxnQQNroyznB0IdYi', '2025-09-23 07:05:02', 'user_3.png', 0),
(7, 'isa', 'beli', 'isa@gmail.com', '$2y$10$1ceP.f/nJjdqG2hSBkYgSeSctaY/nW0QfF3KiHx6Ypk4UlLEC0aJa', '2025-09-25 03:59:57', 'user_7.png', 0),
(8, 'joao', 'victor', 'j@gmail.com', '$2y$10$a8yHsHEDRjPPj96B6NGwZuSBCERZUwjX6h1JUUQrICoFNiC.dpxmq', '2025-09-25 04:21:31', 'user_8.png', 0),
(9, 'theo', 'tavernard', 'theo@gmail.com', '$2y$10$FNBMBMR6KuY4lcozEx.vtOySV7afUdpkA0TJObzZTkNgx1QUsxvam', '2025-09-25 04:22:47', 'user_9.png', 0),
(10, 'Edu', 'Pereira', 'edu@gmail.com', '$2y$10$hXP7jK7EomCZdtGc0dQ/W.BdwHohfA1Ix0b2wLwUDzCkmvNRu5ScG', '2025-09-25 04:25:10', 'user_10.png', 0),
(11, 'alan', 'guilherme', 'alan@gmail.com', '$2y$10$.FXX.oToNoh1rkcfeQPPy.hgPOTo6NzPYnpZK.pm0r5KVrIIG82Qy', '2025-09-25 05:48:17', 'user_11.png', 0);

-- --------------------------------------------------------

--
-- Estrutura para tabela `status_roleta`
--

CREATE TABLE `status_roleta` (
  `id` int(11) NOT NULL,
  `resultado` varchar(255) DEFAULT NULL,
  `girando` tinyint(1) DEFAULT 0,
  `atualizado_em` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `status_roleta`
--

INSERT INTO `status_roleta` (`id`, `resultado`, `girando`, `atualizado_em`) VALUES
(1, NULL, 0, '2025-09-28 09:42:48');

-- --------------------------------------------------------

--
-- Estrutura para tabela `status_votacao`
--

CREATE TABLE `status_votacao` (
  `id` int(11) NOT NULL,
  `roleta_ativa` tinyint(1) DEFAULT 0,
  `ids` varchar(255) DEFAULT NULL,
  `atualizado_em` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `roleta_iniciada` tinyint(1) DEFAULT 0,
  `resultado` varchar(255) DEFAULT NULL,
  `poster_path` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `nome` varchar(100) DEFAULT NULL,
  `posicao` int(11) DEFAULT NULL,
  `votos` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `usuarios`
--

INSERT INTO `usuarios` (`id`, `foto`, `nome`, `posicao`, `votos`) VALUES
(1, 'src/img/FotoEdu.png', 'Eduardo Pereira', 1, 8),
(2, 'src/img/FotoTheo.png', 'Théo Tavernard', 2, 8),
(3, 'src/img/FotoHenrique.jpeg', 'Henrique José', 3, 5),
(4, 'src/img/FotoJoao.png', 'João Victor', 4, 5),
(5, 'src/img/FotoLuka.png', 'Alan Guilherme', 4, 5),
(6, 'src/img/FotoCarlos.png', 'Carlos Henrique', 4, 4),
(7, 'src/img/FotoPalacio.png', 'Guilherme Barros', 5, 2),
(8, 'src/img/FotoGabriel.png', 'Gabriel Izawa', 6, 0),
(9, 'src/img/FotoGeo.png', 'Giovana Dutra', 6, 1);

-- --------------------------------------------------------

--
-- Estrutura para tabela `votos`
--

CREATE TABLE `votos` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `indicacao_id` int(11) NOT NULL,
  `data_voto` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `votos`
--

INSERT INTO `votos` (`id`, `usuario_id`, `indicacao_id`, `data_voto`) VALUES
(2, 1, 7, '2025-09-24 04:15:56'),
(8, 7, 6, '2025-09-25 04:00:13'),
(9, 8, 7, '2025-09-25 04:22:22'),
(10, 9, 6, '2025-09-25 04:23:26');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `filmes`
--
ALTER TABLE `filmes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuario_id` (`usuario_id`);

--
-- Índices de tabela `filme_semana`
--
ALTER TABLE `filme_semana`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `indicacoes`
--
ALTER TABLE `indicacoes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuario_id` (`usuario_id`);

--
-- Índices de tabela `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Índices de tabela `status_roleta`
--
ALTER TABLE `status_roleta`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `status_votacao`
--
ALTER TABLE `status_votacao`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `votos`
--
ALTER TABLE `votos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `usuario_id` (`usuario_id`),
  ADD KEY `indicacao_id` (`indicacao_id`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `filmes`
--
ALTER TABLE `filmes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT de tabela `filme_semana`
--
ALTER TABLE `filme_semana`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT de tabela `indicacoes`
--
ALTER TABLE `indicacoes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de tabela `login`
--
ALTER TABLE `login`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT de tabela `status_roleta`
--
ALTER TABLE `status_roleta`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `status_votacao`
--
ALTER TABLE `status_votacao`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=184;

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de tabela `votos`
--
ALTER TABLE `votos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `filmes`
--
ALTER TABLE `filmes`
  ADD CONSTRAINT `filmes_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`);

--
-- Restrições para tabelas `indicacoes`
--
ALTER TABLE `indicacoes`
  ADD CONSTRAINT `indicacoes_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `login` (`id`);

--
-- Restrições para tabelas `votos`
--
ALTER TABLE `votos`
  ADD CONSTRAINT `votos_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `login` (`id`),
  ADD CONSTRAINT `votos_ibfk_2` FOREIGN KEY (`indicacao_id`) REFERENCES `indicacoes` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
