<?php

namespace Database\Seeders;

use App\Models\Region;
use App\Models\Departement;
use App\Models\SousPrefecture;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class RegionDepartementTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $regionDepartement= [
            [
              "region"=> "AGBOVILLE ",
              "departements"=> [
                  [
                    "name"=>"Agboville ",
                    "sousPrefecture"=> ["Aboudé","Agboville","Ananguié","Attobrou","Azaguié","Céchi","Grand-
                    Morié","Guessiguié","Guessiguié","Oress-
                    Krobou","Rubino"]
                  ], 

                  [
                    "name"=>"Sikensi",
                    "sousPrefecture"=>["Gomon","Sikensi"]
                  ],

                  [
                    "name"=>"Taabo",
                    "sousPrefecture"=>["Paccobo","Taabo"]
                  ],

                  [
                    "name"=>"Tiassalé",
                    "sousPrefecture"=>["Gbolouville","Morokro","N’Douci","Tiassalé"]
                  ]
              ]
            ], 

            [
                "region"=> "TOUBA",
                "departements"=> [
                    [
                      "name"=>"Koro ",
                      "sousPrefecture"=> ["Goulia","Tienko","Mahandiana-Sokourani"]
                    ], 
                    [
                      "name"=>"Ouaninou  ",
                      "sousPrefecture"=>["Kimbrila Nord","Minignan","Sokoro","Tienko"]
                    ],
                    [
                        "name"=>"Touba",
                        "sousPrefecture"=>["Dioman","Foungbesso","Guinteguela","Touba"]
                    ]
                ]
            ],

            [
                "region"=> "BOUNDIALI ",
                "departements"=> [
                    [
                      "name"=>"Boundiali",
                      "sousPrefecture"=> ["Baya","Boundiali","Ganaoni","Kasseré","Siempurgo"]
                    ], 
                    [
                      "name"=>"Kouto",
                      "sousPrefecture"=>["Blessegue","Gbon","Kolia","Kouto","Sanhala"]
                    ],
                    [
                        "name"=>"Tengréla",
                        "sousPrefecture"=>["Débété","Kanakono","Papara","Tengréla"]
                    ]
                ]
            ], 

            [
                "region"=> "TOUMODI",
                "departements"=> [
                    [
                      "name"=>"Didiévi",
                      "sousPrefecture"=> ["Bollo","Didievi","Molonou-Blé","Raviart","Tié-N’diekro"]
                    ], 
                    [
                      "name"=>"Djékanou",
                      "sousPrefecture"=>["Bonikro","Djékanou"]
                    ],
                    [
                        "name"=>"Tiébissou",
                        "sousPrefecture"=>["Lomokankro","Molonou","Tiébissou","Yakpabo-Sakassou"]
                    ],
                    [
                        "name"=>"Toumodi",
                        "sousPrefecture"=>["Angoda","Kokumbo","Kpouebo","Toumodi"]
                    ]
                ]
            ], 

            [
                "region"=> "MANKONO",
                "departements"=> [
                    [
                      "name"=>"Dianra",
                      "sousPrefecture"=> ["Goulia","Tienko","Mahandiana-Sokourani"]
                    ], 
                    [
                      "name"=>"Kounahiri",
                      "sousPrefecture"=>["Kimbrila Nord","Minignan","Sokoro","Tienko"]
                    ],

                    [
                        "name"=>"Mankono",
                        "sousPrefecture"=>["Bouandougou","Mankono","Marandallah","Sarhala","Tiéningboué "]
                    ],

                ]
            ], 

            [
                "region"=> "BOUNA",
                "departements"=> [
                    [
                      "name"=>"Bouna",
                      "sousPrefecture"=> ["Bouka","Bouna","Ondiefidouo","Youndouo"]
                    ], 
                    [
                      "name"=>"Doropo",
                      "sousPrefecture"=>["Danoa","Doropo","Kalamon","Niamoue"]
                    ],
                    [
                        "name"=>"Nassian",
                        "sousPrefecture"=>["Bogofla","Kakpin","Koutouba","Nassian","Sominasse"]
                    ],
                    [
                        "name"=>"Tehini",
                        "sousPrefecture"=>["Gogo","Tehini","Tougbo"]
                    ],
                    
                ]
            ], 

            [
                "region"=> "GUIGLO",
                "departements"=> [
                    [
                      "name"=>"Blolequin",
                      "sousPrefecture"=> ["Blolequin","Diboke","Tinhou","Zeglao"]
                    ], 
                    [
                      "name"=>"Guiglo",
                      "sousPrefecture"=>["Bedy-Goazon","Guiglo","Kaade","Niazahon"]
                    ],
                    [
                        "name"=>"Taï",
                        "sousPrefecture"=>["Taï","Zagne"]
                    ],
                    [
                        "name"=>"Toulepleu",
                        "sousPrefecture"=>["Bakoubli","Meo","Nezobly","Péhé","Tiobly","Toulepleu"]
                    ]
                ]
            ], 

            [
                "region"=> "ABIDJAN",
                "departements"=> [
                    [
                      "name"=>"Abidjan Nord",
                      "sousPrefecture"=> ["Abobo ","Adjame ","Attecoube","Cocody","Plateau","Yopougon "]
                    ], 
                    [
                      "name"=>"Abidjan Sud",
                      "sousPrefecture"=>["Koumassi","Marcory","Port-Bouet","Treichville"]
                    ],
                    [
                        "name"=>"Abidjan Rural Est",
                        "sousPrefecture"=>["Bingerville","Brofodoumé"]
                    ],
                    [
                        "name"=>"Abidjan Rural Ouest ",
                        "sousPrefecture"=>["Anyama","Songon"]
                    ],
                ]
            ], 

            [
                "region"=> "YAMOUSSOUKRO",
                "departements"=> [
                    [
                      "name"=>"Attiégouakro ",
                      "sousPrefecture"=> ["Attiégouakro","Lobo"]
                    ], 
                    [
                      "name"=>"Yamoussoukro ",
                      "sousPrefecture"=>["Kossou","Yamoussoukro"]
                    ]
                ]
            ], 

            [
                "region"=> "MINIGNAN",
                "departements"=> [
                    [
                      "name"=>"Kaniasso",
                      "sousPrefecture"=> ["Goulia","Tienko","Mahandiana-Sokourani"]
                    ], 
                    [
                      "name"=>"Minignan",
                      "sousPrefecture"=>["Kimbrila Nord","Minignan","Sokoro","Tienko"]
                    ]
                ]
            ], 

            [
                "region"=> "BOUAKE",
                "departements"=> [
                    [
                      "name"=>"Béoumi",
                      "sousPrefecture"=> ["Ando-Kekrenou","Béoumi","Bodokro","Kondrobo","Lolobo","Marabadiassa","N’guessankro"]
                    ], 
                    [
                      "name"=>"Botro",
                      "sousPrefecture"=>["Botro","Minignan","Diabo","Krofoinsou","Languibonou"]
                    ],
                    [
                        "name"=>"Bouaké ",
                        "sousPrefecture"=>["Bouaké-ville","Bounda","Brobo","Djebonoua","Mamini"]
                    ],
                    [
                        "name"=>"Sakassou",
                        "sousPrefecture"=>["Ayaou-Sran","Dibri-Assikro","Sakassou","Toumodi-Sakassou"]
                    ],
                ]
            ], 

            [
                "region"=> "SASSANDRA ",
                "departements"=> [
                    [
                      "name"=>"Fresco ",
                      "sousPrefecture"=> ["Dahiri","Fresco","Gbagbam"]
                    ], 
                    [
                      "name"=>"Sassandra",
                      "sousPrefecture"=>["Dakpadou","Grihiri","Lobakuya","Medon","Sago","Sassandra"]
                    ]
                ]
            ], 

            [
                "region"=> "GAGNOA ",
                "departements"=> [
                    [
                      "name"=>"Gagnoa",
                      "sousPrefecture"=> ["Bayota","Dahiepa-Kehi","Dignago","Dougroupalegnoa","Doukouyo","Serihio","Gagnoa","Galebre- Galebouo","Gnagbodounoa","Guiberoua","Ouragahio","Yopohue "],
                    ], 
                    [
                      "name"=>"Oumé",
                      "sousPrefecture"=>["Diégonéfla","Guepahouo","Oumé","Tonla"]
                    ]
                ]
            ], 

            [
                "region"=> "BONDOUKOU ",
                "departements"=> [
                    [
                      "name"=>"Bondoukou ",
                      "sousPrefecture"=> ["Appimandoum","Pinda-Boroko","Bondo","Bondoukou","Gouméré","Laoudi-Ba","Sapli-Sépingo","Sorobango","Tabagne","Tagadi","Taoudi","Yezimala"]
                    ], 
                    [
                      "name"=>"Koun-Fao",
                      "sousPrefecture"=>["Boahia","Kokomian","Kouassi-Datekro","Koun-Fao","Tankéssé","Tienkoikro"]
                    ],
                    [
                        "name"=>"Sandégué",
                        "sousPrefecture"=>["Bandakagni-Tomora","Dimandougou","Sandégué","Yorobodi"]
                    ],
                    [
                        "name"=>"Tanda",
                        "sousPrefecture"=>["Amanvi","Diamba","Tanda","Tchedio"]
                    ],
                    [
                        "name"=>"Transua",
                        "sousPrefecture"=>["Assueferry","Kouassi-Niaguini","Transua "]
                    ]
                ]
            ], 

            [
                "region"=> "DABOU",
                "departements"=> [
                    [
                      "name"=>"Dabou  ",
                      "sousPrefecture"=> ["Dabou","Lopou","Toupah"]
                    ], 
                    
                    [
                      "name"=>"Grand-Lahou ",
                      "sousPrefecture"=>["Ahouanou","Bacanda","Ebonou","Grand-Lahou","Toukouzou"]
                    ],
                    [
                        "name"=>"Jacqueville",
                        "sousPrefecture"=>["Atoutou ","Jacqueville"]
                    ],
                    
                ]
            ], 

            [
                "region"=> "DUEKOUE",
                "departements"=> [
                    [
                      "name"=>"Bangolo ",
                      "sousPrefecture"=> ["Bangolo","Béoué-Zibiao","Bléniméouin"]
                    ], 
                    [
                      "name"=>"Duékoué ",
                      "sousPrefecture"=>["Bagohouo","Duékoué","Gbapleu ","Guézon "]
                    ],
                    [
                        "name"=>"Bagohouo",
                        "sousPrefecture"=>["Facobly","Guezon","Koua","Semien", "Tieny-Seably"]
                    ],
                    [
                        "name"=>"Kouibly",
                        "sousPrefecture"=>["Kouibly","Nidrou","Oulyably-Gnondrou","Totrodrou"]
                    ],
                ]
            ], 

            [
                "region"=> "KATIOLA",
                "departements"=> [
                    [
                      "name"=>"Dabakala ",
                      "sousPrefecture"=> ["Bassawa","Bonieredougou","Dabakala","Foumbolo","niemene","Satama-Sokoro","Satama-Sokoura","Sokala-Sobara","Tiendene-Bambarasso","Yaossedougou"]
                    ], 
                    [
                      "name"=>"Katiola ",
                      "sousPrefecture"=>["Fronan","Katiola","Timbe "]
                    ],
                    [
                        "name"=>"Niakara",
                        "sousPrefecture"=>["Arikokaha","Badikaha","Niédékaha","Niakaramandougou","Tafiré","Tortiya"]
                    ]
                ]
            ], 

            [
                "region"=> "DALOA",
                "departements"=> [
                    [
                      "name"=>"Daloa",
                      "sousPrefecture"=> ["Bediala","Daloa","Gadouan","Gboguhe","Gonate","Zahibo"]
                    ], 
                    [
                      "name"=>"Issia",
                      "sousPrefecture"=>["Boguedia","Iboguhé","Issia","Nahio","Namane","Saïoua","Tapeguia"]
                    ],
                    [
                        "name"=>"Vavoua",
                        "sousPrefecture"=>["Bazra","Nattis","Danano","Dania","KetroBassam","Séitifla","Vavoua"]
                    ],
                    [
                        "name"=>"Zoukougbeu",
                        "sousPrefecture"=>["Domangbeu","Gregbeu","Guessabo","Zoukougbeu"]
                    ],
                ]
            ], 

            [
                "region"=> "DAOUKRO",
                "departements"=> [
                    [
                      "name"=>"Daoukro ",
                      "sousPrefecture"=> ["Goulia","Tienko","Mahandiana-Sokourani"]
                    ], 
                    [
                      "name"=>"Ouelle ",
                      "sousPrefecture"=>["Kimbrila Nord","Minignan","Sokoro","Tienko"]
                    ],
                    [
                        "name"=>"M’bahiakro",
                        "sousPrefecture"=>["Kimbrila Nord","Minignan","Sokoro","Tienko"]
                    ],
                    [
                        "name"=>"Prikro",
                        "sousPrefecture"=>["Anianou","Famienkro","Koffi-Amonkro","Nafana","Prikro"]
                    ],
                ]
            ], 

            [
                "region"=> "ABENGOUROU",
                "departements"=> [
                    [
                      "name"=>"Abengourou",
                      "sousPrefecture"=> ["Goulia","Tienko","Mahandiana-Sokourani"]
                    ], 
                    [
                      "name"=>"Agnibilékrou",
                      "sousPrefecture"=>["Kimbrila Nord","Minignan","Sokoro","Tienko"]
                    ],
                    [
                        "name"=>"Bettié",
                        "sousPrefecture"=>["Bettié","Diamarakro"]
                    ],
                ]
            ], 

            [
                "region"=> "ODIENNE",
                "departements"=> [
                    [
                      "name"=>"Gbéléban",
                      "sousPrefecture"=> ["Gbéléban","Samango ","Seydougou"]
                    ], 
                    [
                      "name"=>"Madinani",
                      "sousPrefecture"=>["Fengolo","Madinani","Ngoloblasso"]
                    ],
                    [
                        "name"=>"Odienné ",
                        "sousPrefecture"=>["Bako","Bougousso","Tiémé ","Dioulatiedougou","Odienné"]
                    ],
                    [
                        "name"=>"Samatiguila",
                        "sousPrefecture"=>["Kimbrila Sud","Samatiguila"]
                    ],
                    [
                        "name"=>"Séguélon ",
                        "sousPrefecture"=>["Gbongaha ","Seguelon "]
                    ],

                ]
            ], 

            [
                "region"=> "DIVO",
                "departements"=> [
                    [
                      "name"=>"Divo  ",
                      "sousPrefecture"=> ["Goulia","Tienko","Mahandiana-Sokourani"]
                    ], 
                    [
                      "name"=>"Guitry ",
                      "sousPrefecture"=>["Dairo-Didizo","Guitry","Lauzoua","Yocoboue"]
                    ],
                    [
                        "name"=>"Lakota  ",
                        "sousPrefecture"=>["Djidji","Gagore","Goudouko","Lakota","Niambezaria","Zikisso"]
                    ],
                    
                ]
            ], 

            [
                "region"=> "BOUAFLE ",
                "departements"=> [
                    [
                      "name"=>"Bonon ",
                      "sousPrefecture"=> ["Goulia","Tienko","Mahandiana-Sokourani"]
                    ], 
                    [
                        "name"=>"Bouafle ",
                        "sousPrefecture"=>["Bouaflé "]
                    ],
                    [
                        "name"=>"Gohitafla",
                        "sousPrefecture"=>["Gohitafla","Iriéfla","Maminigui"]
                    ],
                    [
                        "name"=>"Sinfra ",
                        "sousPrefecture"=>["Bazré","Kononfla","Kouetinfla","Sinfra",""]
                    ],
                    [
                        "name"=>"Zuénoula",
                        "sousPrefecture"=>["Kanzran","Vouéboufla","Zanzra","Zuenoula"]
                    ],
                ]

            ], 

            [
                "region"=> "ADZOPE ",
                "departements"=> [
                    [
                      "name"=>"Adzopé ",
                      "sousPrefecture"=> ["Adzopé","Agou","Annépé","Assikoi","Bécédi-Brignan","Yakassé-Mé"]
                    ], 
                    [
                      "name"=>"Akoupé ",
                      "sousPrefecture"=>["Afféry","Akoupé ","Bécouéfin"]
                    ],
                    [
                        "name"=>"Alépé  ",
                        "sousPrefecture"=>["Aboisso-Comoé","Alepe","Allosso","Danguira","Oghlwapo"]
                    ],
                    [
                        "name"=>"Yakasse-Attobrou",
                        "sousPrefecture"=>["Abongoua","Bieby ","Yakasse-Attobrou"]
                    ],
                ]
            ], 

            [
                "region"=> "BONGOUANOU",
                "departements"=> [
                    [
                      "name"=>"Arrah  ",
                      "sousPrefecture"=> ["Arrah","Kotobi","Krégbé"]
                    ], 
                    [
                      "name"=>"Bongouanou ",
                      "sousPrefecture"=>["Bongouanou","Andé","Assié-Koumassi","N’guessankro"]
                    ],
                    [
                        "name"=>"M’batto ",
                        "sousPrefecture"=>["Anoumaba","Assahara","M’batto","Tiémélékro"]
                    ],
                ]
            ], 

            [
                "region"=> "SOUBRE ",
                "departements"=> [
                    [
                      "name"=>"Buyo",
                      "sousPrefecture"=> ["Buyo","Dapeoua",]
                    ], 
                    [
                      "name"=>"Guéyo ",
                      "sousPrefecture"=>["Dabouyo","Guéyo"]
                    ],
                    [
                       "name"=>"Méagui  ",
                       "sousPrefecture"=>["Gnamangui","Méagui ","Oupoyo ",]
                    ],
                    [
                        "name"=>"Soubré",
                        "sousPrefecture"=>["Grand-Zatry","Liliyo","Okrouyo","Soubré"]
                    ],
                ]
            ], 

            [
                "region"=> "DIMBOKRO  ",
                "departements"=> [
                    [
                      "name"=>"Bocanda ",
                      "sousPrefecture"=> ["Bengassou","Bocanda","Kouadioblékro","N’zèkrézessou"]
                    ], 
                    [
                      "name"=>"Dimbokro ",
                      "sousPrefecture"=>["Dimbokro","Abigui","Diangokro","Dimbokro","Nofou"]
                    ],
                    [
                        "name"=>"Kouassi-Kouassikro",
                        "sousPrefecture"=>["Kouassi-Kouassikro","Mekro "]
                    ],
                ]
            ], 

            [
                "region"=> "KORHOGO ",
                "departements"=> [
                    [
                      "name"=>"Dikodougou ",
                      "sousPrefecture"=> ["Boron","Dikodougou ","Guiembé  "]
                    ], 
                    [
                      "name"=>"Korhogo ",
                      "sousPrefecture"=>["Korhogo ","Dassoungboho","Kanoroba","Karakoro","Kiemou","Kombolokoura","Komborodougou","Koni","Lataha","Nafoun","Napiéolédougou","N’Ganon","Niofoin","Sirasso","Sohouo","Tioroniaradougou"]
                    ],
                    [
                        "name"=>"M’Bengué",
                        "sousPrefecture"=>["Bougou","Katiali","Katogo","M’bengué"]
                    ],
                    [
                        "name"=>"Sinématiali",
                        "sousPrefecture"=>["Bouakaha","Kagbolodougou","Sediogo ","Sinématiali "]
                    ],
                ]
            ], 

            [
                "region"=> "SAN-PEDRO",
                "departements"=> [
                    [
                      "name"=>"San-Pédro ",
                      "sousPrefecture"=> ["Doba","Dogbo","Gabiadji","Grand-Bereby ","San-Pédro "]
                    ], 
                    [
                      "name"=>"Tabou  ",
                      "sousPrefecture"=>["Dapo-Iboke","Djamandioke","Djouroutou","Grabo Olodio","Tabou  "]
                    ]
                ]
            ], 

            [
                "region"=> "ABOISSO ",
                "departements"=> [
                    [
                      "name"=>"Aboisso ",
                      "sousPrefecture"=> ["Aboisso","Adaou","Adjouan","Ayamé","Bianouan","Kouakro","Maféré ","Yaou "]
                    ], 
                    [
                      "name"=>"Adiaké ",
                      "sousPrefecture"=>["Adiaké ","Adiaké","Assinie-Mafia ","Etuéboué "]
                    ],
                    [
                        "name"=>"Grand-Bassam  ",
                        "sousPrefecture"=>["Bongo","Bonoua ","Grand-Bassam "]
                    ],
                    [
                        "name"=>"Tiapoum",
                        "sousPrefecture"=>["Noé","Nouamou ","Tiapoum"]
                    ],

                ]
            ], 

            [
                "region"=> "FERKESSEDOUGOU ",
                "departements"=> [
                    [
                      "name"=>"Ferkessédougou",
                      "sousPrefecture"=> ["Ferkessédougou","Koumbala ","Togoniéré "]
                    ], 
                    [
                      "name"=>"Kong ",
                      "sousPrefecture"=>["Bilimono","Kong","Nafana ","Sikolo "]
                    ],
                    [
                        "name"=>"Ouangolodougou ",
                        "sousPrefecture"=>["Diawala","Kaouara","Niellé","Ouangolo ","Toumoukro "]
                    ],
                ]
            ], 

            [
                "region"=> "MAN ",
                "departements"=> [
                    [
                      "name"=>"Biankouma ",
                      "sousPrefecture"=> ["Biankouma","Blapleu","Gbangbégouiné","Gbonné","Gouiné","Kpata ","Santa "]
                    ], 
                    [
                      "name"=>"Danané ",
                      "sousPrefecture"=>["Daleu","Danané","Gbon-Houyé","Kouan-Houlé","Mahapleu","Seileu ","Zonneu  "]
                    ],
                    [
                        "name"=>"Man  ",
                        "sousPrefecture"=>["Bogouiné","Fagnampleu","Gbangbenouine-Yati","Logoualé","Man","Podiagouiné","Sandougou-Soba","Sangouiné","Yapleu","Zagoué","Ziogouiné "]
                    ],
                    [
                        "name"=>"Sipilou   ",
                        "sousPrefecture"=>["Sipilou","Yorodougou ",]
                    ],
                    [
                        "name"=>"Zouan-Hounien",
                        "sousPrefecture"=>["Banneu","Bin-Houyé","Goulaleu","Téapleu","Yelleu ","Zouan-Hounien "]
                    ],
                    
                ]
            ], 

            [
                "region"=> "SEGUELA ",
                "departements"=> [
                    [
                      "name"=>"Kani ",
                      "sousPrefecture"=> ["Djibrosso","Fadiadougou","Kani","Morondo "]
                    ], 
                    [
                      "name"=>"Séguéla ",
                      "sousPrefecture"=>["Bobi-Diarabana","Dualla","Kamalo","Massala","Séguéla","Sifié ","Worofla "]
                    ]
                ]
            ], 

        ];

        foreach ($regionDepartement as $regionData) {
            $region = Region::create([
                'name' => $regionData['region']
            ]);

            foreach ($regionData['departements'] as $departementData) {
                $departement = $region->departements()->create([
                    'name' => $departementData['name']
                ]);

                foreach ($departementData['sousPrefecture'] as $sousPrefectureName) {
                    $departement->sousPrefectures()->create([
                        'name' => $sousPrefectureName
                    ]);
                }
            }
        }
    }

}