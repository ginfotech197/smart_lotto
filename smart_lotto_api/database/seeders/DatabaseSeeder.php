<?php

namespace Database\Seeders;

use App\Models\CardCombination;
use App\Models\CardDrawMaster;
use App\Models\DrawMaster;
use App\Models\Game;
use App\Models\GameType;
use App\Models\Message;
use App\Models\SingleNumber;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\UserType;
use App\Models\NumberCombination;
use App\Models\ResultMaster;
use App\Models\NextGameDraw;
use App\Models\ResultDetail;
use App\Models\TwoDigitNumberCombinations;
use App\Models\TwoDigitNumberSets;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        //person_types table data
        UserType::create(['user_type_name' => 'Admin']);
        UserType::create(['user_type_name' => 'Developer']);
        UserType::create(['user_type_name' => 'Stockist']);
        UserType::create(['user_type_name' => 'Terminal']);
        $this->command->info('User Type creation Finished');

        User::create(['user_name'=>'Arindam Biswas','email'=>'1001','password'=>"b084d54d1291fe9b331c2fc6dda96bfa",'mobile1'=>'9836444999','user_type_id'=>1,'closing_balance' => 5000]);
        User::create(['user_name'=>'Ananda Sen','email'=>'1002','password'=>"fba9d88164f3e2d9109ee770223212a0",'mobile1'=>'9536485201','user_type_id'=>2,'closing_balance' => 5000]);
        User::create(['user_name'=>'Mahesh Roy','email'=>'1003','password'=>"aa68c75c4a77c87f97fb686b2f068676",'mobile1'=>'8532489030','user_type_id'=>3,'closing_balance' => 5000]);
        User::create(['user_name'=>'Ramesh Ghosh','email'=>'1004','password'=>"64b2ef6b3ae81bee59d24cf69e5749dd",'mobile1'=>'9587412358','user_type_id'=>4,'closing_balance' => 5000]);

        SingleNumber::insert([
            ['single_number' => 1, 'single_order' => 1],
            ['single_number' => 2, 'single_order' => 2],
            ['single_number' => 3, 'single_order' => 3],
            ['single_number' => 4, 'single_order' => 4],
            ['single_number' => 5, 'single_order' => 5],
            ['single_number' => 6, 'single_order' => 6],
            ['single_number' => 7, 'single_order' => 7],
            ['single_number' => 8, 'single_order' => 8],
            ['single_number' => 9, 'single_order' => 9],
            ['single_number' => 0, 'single_order' => 10]
        ]);

        NumberCombination::insert([
            ['single_number_id' =>1, 'triple_number' => 100, 'visible_triple_number' => '100'],// #1
            ['single_number_id' =>1, 'triple_number' => 678, 'visible_triple_number' => '678'],// #2
            ['single_number_id' =>1, 'triple_number' => 777, 'visible_triple_number' => '777'],// #3
            ['single_number_id' =>1, 'triple_number' => 560, 'visible_triple_number' => '560'],// #4
            ['single_number_id' =>1, 'triple_number' => 470, 'visible_triple_number' => '470'],// #5
            ['single_number_id' =>1, 'triple_number' => 380, 'visible_triple_number' => '380'],// #6
            ['single_number_id' =>1, 'triple_number' => 290, 'visible_triple_number' => '290'],// #7
            ['single_number_id' =>1, 'triple_number' => 119, 'visible_triple_number' => '119'],// #8
            ['single_number_id' =>1, 'triple_number' => 137, 'visible_triple_number' => '137'],// #9
            ['single_number_id' =>1, 'triple_number' => 236, 'visible_triple_number' => '236'],// #10
            ['single_number_id' =>1, 'triple_number' => 146, 'visible_triple_number' => '146'],// #11
            ['single_number_id' =>1, 'triple_number' => 669, 'visible_triple_number' => '669'],// #12
            ['single_number_id' =>1, 'triple_number' => 579, 'visible_triple_number' => '579'],// #13
            ['single_number_id' =>1, 'triple_number' => 399, 'visible_triple_number' => '399'],// #14
            ['single_number_id' =>1, 'triple_number' => 588, 'visible_triple_number' => '588'],// #15
            ['single_number_id' =>1, 'triple_number' => 489, 'visible_triple_number' => '489'],// #16
            ['single_number_id' =>1, 'triple_number' => 245, 'visible_triple_number' => '245'],// #17
            ['single_number_id' =>1, 'triple_number' => 155, 'visible_triple_number' => '155'],// #18
            ['single_number_id' =>1, 'triple_number' => 227, 'visible_triple_number' => '227'],// #19
            ['single_number_id' =>1, 'triple_number' => 344, 'visible_triple_number' => '344'],// #20
            ['single_number_id' =>1, 'triple_number' => 335, 'visible_triple_number' => '335'],// #21
            ['single_number_id' =>1, 'triple_number' => 128, 'visible_triple_number' => '128'],// #22


            ['single_number_id' =>2, 'triple_number' => 200, 'visible_triple_number' => '200'],// #1
            ['single_number_id' =>2, 'triple_number' => 345, 'visible_triple_number' => '345'],// #2
            ['single_number_id' =>2, 'triple_number' => 444, 'visible_triple_number' => '444'],// #3
            ['single_number_id' =>2, 'triple_number' => 570, 'visible_triple_number' => '570'],// #4
            ['single_number_id' =>2, 'triple_number' => 480, 'visible_triple_number' => '480'],// #5
            ['single_number_id' =>2, 'triple_number' => 390, 'visible_triple_number' => '390'],// #6
            ['single_number_id' =>2, 'triple_number' => 660, 'visible_triple_number' => '660'],// #7
            ['single_number_id' =>2, 'triple_number' => 129, 'visible_triple_number' => '129'],// #8
            ['single_number_id' =>2, 'triple_number' => 237, 'visible_triple_number' => '237'],// #9
            ['single_number_id' =>2, 'triple_number' => 336, 'visible_triple_number' => '336'],// #10
            ['single_number_id' =>2, 'triple_number' => 246, 'visible_triple_number' => '246'],// #11
            ['single_number_id' =>2, 'triple_number' => 679, 'visible_triple_number' => '679'],// #12
            ['single_number_id' =>2, 'triple_number' => 255, 'visible_triple_number' => '255'],// #13
            ['single_number_id' =>2, 'triple_number' => 147, 'visible_triple_number' => '147'],// #14
            ['single_number_id' =>2, 'triple_number' => 228, 'visible_triple_number' => '228'],// #15
            ['single_number_id' =>2, 'triple_number' => 499, 'visible_triple_number' => '499'],// #16
            ['single_number_id' =>2, 'triple_number' => 688, 'visible_triple_number' => '688'],// #17
            ['single_number_id' =>2, 'triple_number' => 778, 'visible_triple_number' => '778'],// #18
            ['single_number_id' =>2, 'triple_number' => 138, 'visible_triple_number' => '138'],// #19
            ['single_number_id' =>2, 'triple_number' => 156, 'visible_triple_number' => '156'],// #20
            ['single_number_id' =>2, 'triple_number' => 110, 'visible_triple_number' => '110'],// #21
            ['single_number_id' =>2, 'triple_number' => 589, 'visible_triple_number' => '589'],// #22

            ['single_number_id' =>3, 'triple_number' => 300, 'visible_triple_number' => '300'],// #1
            ['single_number_id' =>3, 'triple_number' => 120, 'visible_triple_number' => '120'],// #2
            ['single_number_id' =>3, 'triple_number' => 111, 'visible_triple_number' => '111'],// #3
            ['single_number_id' =>3, 'triple_number' => 580, 'visible_triple_number' => '580'],// #4
            ['single_number_id' =>3, 'triple_number' => 490, 'visible_triple_number' => '490'],// #5
            ['single_number_id' =>3, 'triple_number' => 670, 'visible_triple_number' => '670'],// #6
            ['single_number_id' =>3, 'triple_number' => 238, 'visible_triple_number' => '238'],// #7
            ['single_number_id' =>3, 'triple_number' => 139, 'visible_triple_number' => '139'],// #8
            ['single_number_id' =>3, 'triple_number' => 337, 'visible_triple_number' => '337'],// #9
            ['single_number_id' =>3, 'triple_number' => 157, 'visible_triple_number' => '157'],// #10
            ['single_number_id' =>3, 'triple_number' => 346, 'visible_triple_number' => '346'],// #11
            ['single_number_id' =>3, 'triple_number' => 689, 'visible_triple_number' => '689'],// #12
            ['single_number_id' =>3, 'triple_number' => 355, 'visible_triple_number' => '355'],// #13
            ['single_number_id' =>3, 'triple_number' => 247, 'visible_triple_number' => '247'],// #14
            ['single_number_id' =>3, 'triple_number' => 256, 'visible_triple_number' => '256'],// #15
            ['single_number_id' =>3, 'triple_number' => 166, 'visible_triple_number' => '166'],// #16
            ['single_number_id' =>3, 'triple_number' => 599, 'visible_triple_number' => '599'],// #17
            ['single_number_id' =>3, 'triple_number' => 148, 'visible_triple_number' => '148'],// #18
            ['single_number_id' =>3, 'triple_number' => 788, 'visible_triple_number' => '788'],// #19
            ['single_number_id' =>3, 'triple_number' => 445, 'visible_triple_number' => '445'],// #20
            ['single_number_id' =>3, 'triple_number' => 229, 'visible_triple_number' => '229'],// #21
            ['single_number_id' =>3, 'triple_number' => 779, 'visible_triple_number' => '779'],// #22

            ['single_number_id' =>4,'triple_number'=>400,'visible_triple_number'=>'400'],// #1
            ['single_number_id' =>4,'triple_number'=>789,'visible_triple_number'=>'789'],// #2
            ['single_number_id' =>4,'triple_number'=>888,'visible_triple_number'=>'888'],// #3
            ['single_number_id' =>4,'triple_number'=>590,'visible_triple_number'=>'590'],// #4
            ['single_number_id' =>4,'triple_number'=>130,'visible_triple_number'=>'130'],// #5
            ['single_number_id' =>4,'triple_number'=>680,'visible_triple_number'=>'680'],// #6
            ['single_number_id' =>4,'triple_number'=>248,'visible_triple_number'=>'248'],// #7
            ['single_number_id' =>4,'triple_number'=>149,'visible_triple_number'=>'149'],// #8
            ['single_number_id' =>4,'triple_number'=>347,'visible_triple_number'=>'347'],// #9
            ['single_number_id' =>4,'triple_number'=>158,'visible_triple_number'=>'158'],// #10
            ['single_number_id' =>4,'triple_number'=>446,'visible_triple_number'=>'446'],// #11
            ['single_number_id' =>4,'triple_number'=>699,'visible_triple_number'=>'699'],// #12
            ['single_number_id' =>4,'triple_number'=>455,'visible_triple_number'=>'455'],// #13
            ['single_number_id' =>4,'triple_number'=>266,'visible_triple_number'=>'266'],// #14
            ['single_number_id' =>4,'triple_number'=>112,'visible_triple_number'=>'112'],// #15
            ['single_number_id' =>4,'triple_number'=>356,'visible_triple_number'=>'356'],// #16
            ['single_number_id' =>4,'triple_number'=>239,'visible_triple_number'=>'239'],// #17
            ['single_number_id' =>4,'triple_number'=>338,'visible_triple_number'=>'338'],// #18
            ['single_number_id' =>4,'triple_number'=>257,'visible_triple_number'=>'257'],// #19
            ['single_number_id' =>4,'triple_number'=>220,'visible_triple_number'=>'220'],// #20
            ['single_number_id' =>4,'triple_number'=>770,'visible_triple_number'=>'770'],// #21
            ['single_number_id' =>4,'triple_number'=>167,'visible_triple_number'=>'167'],// #22

            ['single_number_id' =>5,'triple_number'=>500,'visible_triple_number'=>'500'],// #1
            ['single_number_id' =>5,'triple_number'=>456,'visible_triple_number'=>'456'],// #2
            ['single_number_id' =>5,'triple_number'=>555,'visible_triple_number'=>'555'],// #3
            ['single_number_id' =>5,'triple_number'=>140,'visible_triple_number'=>'140'],// #4
            ['single_number_id' =>5,'triple_number'=>230,'visible_triple_number'=>'230'],// #5
            ['single_number_id' =>5,'triple_number'=>690,'visible_triple_number'=>'690'],// #6
            ['single_number_id' =>5,'triple_number'=>258,'visible_triple_number'=>'258'],// #7
            ['single_number_id' =>5,'triple_number'=>159,'visible_triple_number'=>'159'],// #8
            ['single_number_id' =>5,'triple_number'=>357,'visible_triple_number'=>'357'],// #9
            ['single_number_id' =>5,'triple_number'=>799,'visible_triple_number'=>'799'],// #10
            ['single_number_id' =>5,'triple_number'=>267,'visible_triple_number'=>'267'],// #11
            ['single_number_id' =>5,'triple_number'=>780,'visible_triple_number'=>'780'],// #12
            ['single_number_id' =>5,'triple_number'=>447,'visible_triple_number'=>'447'],// #13
            ['single_number_id' =>5,'triple_number'=>366,'visible_triple_number'=>'366'],// #14
            ['single_number_id' =>5,'triple_number'=>113,'visible_triple_number'=>'113'],// #15
            ['single_number_id' =>5,'triple_number'=>122,'visible_triple_number'=>'122'],// #16
            ['single_number_id' =>5,'triple_number'=>177,'visible_triple_number'=>'177'],// #17
            ['single_number_id' =>5,'triple_number'=>249,'visible_triple_number'=>'249'],// #18
            ['single_number_id' =>5,'triple_number'=>339,'visible_triple_number'=>'339'],// #19
            ['single_number_id' =>5,'triple_number'=>889,'visible_triple_number'=>'889'],// #20
            ['single_number_id' =>5,'triple_number'=>348,'visible_triple_number'=>'348'],// #21
            ['single_number_id' =>5,'triple_number'=>168,'visible_triple_number'=>'168'],// #22

            ['single_number_id' =>6,'triple_number'=>600,'visible_triple_number'=>'600'],// #1
            ['single_number_id' =>6,'triple_number'=>123,'visible_triple_number'=>'123'],// #2
            ['single_number_id' =>6,'triple_number'=>222,'visible_triple_number'=>'222'],// #3
            ['single_number_id' =>6,'triple_number'=>150,'visible_triple_number'=>'150'],// #4
            ['single_number_id' =>6,'triple_number'=>330,'visible_triple_number'=>'330'],// #5
            ['single_number_id' =>6,'triple_number'=>240,'visible_triple_number'=>'240'],// #6
            ['single_number_id' =>6,'triple_number'=>268,'visible_triple_number'=>'268'],// #7
            ['single_number_id' =>6,'triple_number'=>169,'visible_triple_number'=>'169'],// #8
            ['single_number_id' =>6,'triple_number'=>367,'visible_triple_number'=>'367'],// #9
            ['single_number_id' =>6,'triple_number'=>448,'visible_triple_number'=>'448'],// #10
            ['single_number_id' =>6,'triple_number'=>899,'visible_triple_number'=>'899'],// #11
            ['single_number_id' =>6,'triple_number'=>178,'visible_triple_number'=>'178'],// #12
            ['single_number_id' =>6,'triple_number'=>790,'visible_triple_number'=>'790'],// #13
            ['single_number_id' =>6,'triple_number'=>466,'visible_triple_number'=>'466'],// #14
            ['single_number_id' =>6,'triple_number'=>358,'visible_triple_number'=>'358'],// #15
            ['single_number_id' =>6,'triple_number'=>880,'visible_triple_number'=>'880'],// #16
            ['single_number_id' =>6,'triple_number'=>114,'visible_triple_number'=>'114'],// #17
            ['single_number_id' =>6,'triple_number'=>556,'visible_triple_number'=>'556'],// #18
            ['single_number_id' =>6,'triple_number'=>259,'visible_triple_number'=>'259'],// #19
            ['single_number_id' =>6,'triple_number'=>349,'visible_triple_number'=>'349'],// #20
            ['single_number_id' =>6,'triple_number'=>457,'visible_triple_number'=>'457'],// #21
            ['single_number_id' =>6,'triple_number'=>277,'visible_triple_number'=>'277'],// #22

            ['single_number_id' =>7,'triple_number'=>700,'visible_triple_number'=>'700'],// #1
            ['single_number_id' =>7,'triple_number'=>890,'visible_triple_number'=>'890'],// #2
            ['single_number_id' =>7,'triple_number'=>999,'visible_triple_number'=>'999'],// #3
            ['single_number_id' =>7,'triple_number'=>160,'visible_triple_number'=>'160'],// #4
            ['single_number_id' =>7,'triple_number'=>340,'visible_triple_number'=>'340'],// #5
            ['single_number_id' =>7,'triple_number'=>250,'visible_triple_number'=>'250'],// #6
            ['single_number_id' =>7,'triple_number'=>278,'visible_triple_number'=>'278'],// #7
            ['single_number_id' =>7,'triple_number'=>179,'visible_triple_number'=>'179'],// #8
            ['single_number_id' =>7,'triple_number'=>377,'visible_triple_number'=>'377'],// #9
            ['single_number_id' =>7,'triple_number'=>467,'visible_triple_number'=>'467'],// #10
            ['single_number_id' =>7,'triple_number'=>115,'visible_triple_number'=>'115'],// #11
            ['single_number_id' =>7,'triple_number'=>124,'visible_triple_number'=>'124'],// #12
            ['single_number_id' =>7,'triple_number'=>223,'visible_triple_number'=>'223'],// #13
            ['single_number_id' =>7,'triple_number'=>566,'visible_triple_number'=>'566'],// #14
            ['single_number_id' =>7,'triple_number'=>557,'visible_triple_number'=>'557'],// #15
            ['single_number_id' =>7,'triple_number'=>368,'visible_triple_number'=>'368'],// #16
            ['single_number_id' =>7,'triple_number'=>359,'visible_triple_number'=>'359'],// #17
            ['single_number_id' =>7,'triple_number'=>449,'visible_triple_number'=>'449'],// #18
            ['single_number_id' =>7,'triple_number'=>269,'visible_triple_number'=>'269'],// #19
            ['single_number_id' =>7,'triple_number'=>133,'visible_triple_number'=>'133'],// #20
            ['single_number_id' =>7,'triple_number'=>188,'visible_triple_number'=>'188'],// #21
            ['single_number_id' =>7,'triple_number'=>458,'visible_triple_number'=>'458'],// #22

            ['single_number_id' =>8,'triple_number'=>800,'visible_triple_number'=>'800'],// #1
            ['single_number_id' =>8,'triple_number'=>567,'visible_triple_number'=>'567'],// #2
            ['single_number_id' =>8,'triple_number'=>666,'visible_triple_number'=>'666'],// #3
            ['single_number_id' =>8,'triple_number'=>170,'visible_triple_number'=>'170'],// #4
            ['single_number_id' =>8,'triple_number'=>350,'visible_triple_number'=>'350'],// #5
            ['single_number_id' =>8,'triple_number'=>260,'visible_triple_number'=>'260'],// #6
            ['single_number_id' =>8,'triple_number'=>288,'visible_triple_number'=>'288'],// #7
            ['single_number_id' =>8,'triple_number'=>189,'visible_triple_number'=>'189'],// #8
            ['single_number_id' =>8,'triple_number'=>116,'visible_triple_number'=>'116'],// #9
            ['single_number_id' =>8,'triple_number'=>233,'visible_triple_number'=>'233'],// #10
            ['single_number_id' =>8,'triple_number'=>459,'visible_triple_number'=>'459'],// #11
            ['single_number_id' =>8,'triple_number'=>125,'visible_triple_number'=>'125'],// #12
            ['single_number_id' =>8,'triple_number'=>224,'visible_triple_number'=>'224'],// #13
            ['single_number_id' =>8,'triple_number'=>477,'visible_triple_number'=>'447'],// #14
            ['single_number_id' =>8,'triple_number'=>990,'visible_triple_number'=>'990'],// #15
            ['single_number_id' =>8,'triple_number'=>134,'visible_triple_number'=>'134'],// #16
            ['single_number_id' =>8,'triple_number'=>558,'visible_triple_number'=>'558'],// #17
            ['single_number_id' =>8,'triple_number'=>369,'visible_triple_number'=>'369'],// #18
            ['single_number_id' =>8,'triple_number'=>378,'visible_triple_number'=>'378'],// #19
            ['single_number_id' =>8,'triple_number'=>440,'visible_triple_number'=>'440'],// #20
            ['single_number_id' =>8,'triple_number'=>279,'visible_triple_number'=>'279'],// #21
            ['single_number_id' =>8,'triple_number'=>468,'visible_triple_number'=>'468'],// #22

            ['single_number_id' =>9,'triple_number'=>900,'visible_triple_number'=>'900'],// #1
            ['single_number_id' =>9,'triple_number'=>234,'visible_triple_number'=>'234'],// #2
            ['single_number_id' =>9,'triple_number'=>333,'visible_triple_number'=>'333'],// #3
            ['single_number_id' =>9,'triple_number'=>180,'visible_triple_number'=>'180'],// #4
            ['single_number_id' =>9,'triple_number'=>360,'visible_triple_number'=>'360'],// #5
            ['single_number_id' =>9,'triple_number'=>270,'visible_triple_number'=>'270'],// #6
            ['single_number_id' =>9,'triple_number'=>450,'visible_triple_number'=>'450'],// #7
            ['single_number_id' =>9,'triple_number'=>199,'visible_triple_number'=>'199'],// #8
            ['single_number_id' =>9,'triple_number'=>117,'visible_triple_number'=>'117'],// #9
            ['single_number_id' =>9,'triple_number'=>469,'visible_triple_number'=>'469'],// #10
            ['single_number_id' =>9,'triple_number'=>126,'visible_triple_number'=>'126'],// #11
            ['single_number_id' =>9,'triple_number'=>667,'visible_triple_number'=>'667'],// #12
            ['single_number_id' =>9,'triple_number'=>478,'visible_triple_number'=>'478'],// #13
            ['single_number_id' =>9,'triple_number'=>135,'visible_triple_number'=>'135'],// #14
            ['single_number_id' =>9,'triple_number'=>225,'visible_triple_number'=>'225'],// #15
            ['single_number_id' =>9,'triple_number'=>144,'visible_triple_number'=>'144'],// #16
            ['single_number_id' =>9,'triple_number'=>379,'visible_triple_number'=>'379'],// #17
            ['single_number_id' =>9,'triple_number'=>559,'visible_triple_number'=>'559'],// #18
            ['single_number_id' =>9,'triple_number'=>289,'visible_triple_number'=>'289'],// #19
            ['single_number_id' =>9,'triple_number'=>388,'visible_triple_number'=>'388'],// #20
            ['single_number_id' =>9,'triple_number'=>577,'visible_triple_number'=>'577'],// #21
            ['single_number_id' =>9,'triple_number'=>568,'visible_triple_number'=>'568'],// #22

            ['single_number_id' =>10, 'triple_number' => 000, 'visible_triple_number' => 'OOO'],// #1
            ['single_number_id' =>10, 'triple_number' => 127, 'visible_triple_number' => '127'],// #2
            ['single_number_id' =>10, 'triple_number' => 190, 'visible_triple_number' => '190'],// #3
            ['single_number_id' =>10, 'triple_number' => 280, 'visible_triple_number' => '280'],// #4
            ['single_number_id' =>10, 'triple_number' => 370, 'visible_triple_number' => '370'],// #5
            ['single_number_id' =>10, 'triple_number' => 460, 'visible_triple_number' => '460'],// #6
            ['single_number_id' =>10, 'triple_number' => 550, 'visible_triple_number' => '550'],// #7
            ['single_number_id' =>10, 'triple_number' => 235, 'visible_triple_number' => '235'],// #8
            ['single_number_id' =>10, 'triple_number' => 118, 'visible_triple_number' => '118'],// #9
            ['single_number_id' =>10, 'triple_number' => 578, 'visible_triple_number' => '578'],// #10
            ['single_number_id' =>10, 'triple_number' => 145, 'visible_triple_number' => '145'],// #11
            ['single_number_id' =>10, 'triple_number' => 479, 'visible_triple_number' => '479'],// #12
            ['single_number_id' =>10, 'triple_number' => 668, 'visible_triple_number' => '668'],// #13
            ['single_number_id' =>10, 'triple_number' => 299, 'visible_triple_number' => '299'],// #14
            ['single_number_id' =>10, 'triple_number' => 334, 'visible_triple_number' => '334'],// #15
            ['single_number_id' =>10, 'triple_number' => 488, 'visible_triple_number' => '488'],// #16
            ['single_number_id' =>10, 'triple_number' => 389, 'visible_triple_number' => '389'],// #17
            ['single_number_id' =>10, 'triple_number' => 226, 'visible_triple_number' => '226'],// #18
            ['single_number_id' =>10, 'triple_number' => 569, 'visible_triple_number' => '569'],// #19
            ['single_number_id' =>10, 'triple_number' => 677, 'visible_triple_number' => '677'],// #20
            ['single_number_id' =>10, 'triple_number' => 136, 'visible_triple_number' => '136'],// #21
            ['single_number_id' =>10, 'triple_number' => 244, 'visible_triple_number' => '244'],// #22

        ]);

        DrawMaster::insert([

            //15 min difference

            ['draw_name'=> 'Good morning','start_time'=>'12:00','end_time'=>'09:00','time_diff'=>'15','visible_time'=>'09:00 am','active'=>1],
            ['draw_name'=> 'Good morning','start_time'=>'09:00','end_time'=>'09:15','time_diff'=>'15','visible_time'=>'09:15 am','active'=>0],
            ['draw_name'=> 'Good afternoon','start_time'=>'09:15','end_time'=>'09:30','time_diff'=>'15','visible_time'=>'09:30 am','active'=>0],
            ['draw_name'=> 'Good evening','start_time'=>'09:30','end_time'=>'09:45','time_diff'=>'15','visible_time'=>'09:45 am','active'=>0],
            ['draw_name'=> 'Lets play','start_time'=>'09:45','end_time'=>'10:00','time_diff'=>'15','visible_time'=>'10:00 am','active'=>0],
            ['draw_name'=> 'Good night','start_time'=>'10:00','end_time'=>'10:15','time_diff'=>'15','visible_time'=>'10:15 am','active'=>0],
            ['draw_name'=> 'Good night','start_time'=>'10:15','end_time'=>'10:30','time_diff'=>'15','visible_time'=>'10:30 am','active'=>0],
            ['draw_name'=> 'Good morning','start_time'=>'10:30','end_time'=>'10:45','time_diff'=>'15','visible_time'=>'10:45 am','active'=>0],
            ['draw_name'=> 'Good afternoon','start_time'=>'10:45','end_time'=>'11:00','time_diff'=>'15','visible_time'=>'11:00 am','active'=>0],
            ['draw_name'=> 'Good morning','start_time'=>'11:00 ','end_time'=>'11:15','time_diff'=>'15','visible_time'=>'11:15 am','active'=>0],
            ['draw_name'=> 'Good morning','start_time'=>'11:15 ','end_time'=>'11:30','time_diff'=>'15','visible_time'=>'11:30 am','active'=>0],
            ['draw_name'=> 'Good morning','start_time'=>'11:30 ','end_time'=>'11:45','time_diff'=>'15','visible_time'=>'11:45 am','active'=>0],
            ['draw_name'=> 'Good morning','start_time'=>'11:45 ','end_time'=>'12:00','time_diff'=>'15','visible_time'=>'12:00 pm','active'=>0],
            ['draw_name'=> 'Good morning','start_time'=>'12:00 ','end_time'=>'12:15','time_diff'=>'15','visible_time'=>'12:15 pm','active'=>0],
            ['draw_name'=> 'Good morning','start_time'=>'12:15 ','end_time'=>'12:30','time_diff'=>'15','visible_time'=>'12:30 pm','active'=>0],
            ['draw_name'=> 'Good morning','start_time'=>'12:30 ','end_time'=>'12:45','time_diff'=>'15','visible_time'=>'12:45 pm','active'=>0],
            ['draw_name'=> 'Good morning','start_time'=>'12:45 ','end_time'=>'13:00','time_diff'=>'15','visible_time'=>'01:00 pm','active'=>0],
            ['draw_name'=> 'Good morning','start_time'=>'13:00 ','end_time'=>'13:15','time_diff'=>'15','visible_time'=>'01:15 pm','active'=>0],
            ['draw_name'=> 'Good morning','start_time'=>'13:15 ','end_time'=>'13:30','time_diff'=>'15','visible_time'=>'01:30 pm','active'=>0],
            ['draw_name'=> 'Good morning','start_time'=>'13:30 ','end_time'=>'13:45','time_diff'=>'15','visible_time'=>'01:45 pm','active'=>0],
            ['draw_name'=> 'Good morning','start_time'=>'13:45 ','end_time'=>'14:00','time_diff'=>'15','visible_time'=>'02:00 pm','active'=>0],
            ['draw_name'=> 'Good morning','start_time'=>'14:00 ','end_time'=>'14:15','time_diff'=>'15','visible_time'=>'02:15 pm','active'=>0],
            ['draw_name'=> 'Good morning','start_time'=>'14:15 ','end_time'=>'14:30','time_diff'=>'15','visible_time'=>'02:30 pm','active'=>0],
            ['draw_name'=> 'Good morning','start_time'=>'14:30 ','end_time'=>'14:45','time_diff'=>'15','visible_time'=>'02:45 pm','active'=>0],
            ['draw_name'=> 'Good morning','start_time'=>'14:45 ','end_time'=>'15:00','time_diff'=>'15','visible_time'=>'03:00 pm','active'=>0],
            ['draw_name'=> 'Good morning','start_time'=>'15:00 ','end_time'=>'15:15','time_diff'=>'15','visible_time'=>'03:15 pm','active'=>0],
            ['draw_name'=> 'Good morning','start_time'=>'15:15 ','end_time'=>'15:30','time_diff'=>'15','visible_time'=>'03:30 pm','active'=>0],
            ['draw_name'=> 'Good morning','start_time'=>'15:30 ','end_time'=>'15:45','time_diff'=>'15','visible_time'=>'03:45 pm','active'=>0],
            ['draw_name'=> 'Good morning','start_time'=>'15:45 ','end_time'=>'16:00','time_diff'=>'15','visible_time'=>'04:00 pm','active'=>0],

            //20 min difference
            ['draw_name'=> 'Good morning','start_time'=>'16:00 ','end_time'=>'16:20','time_diff'=>'20','visible_time'=>'04:20 pm','active'=>0],
            ['draw_name'=> 'Good morning','start_time'=>'16:20 ','end_time'=>'16:40','time_diff'=>'20','visible_time'=>'04:40 pm','active'=>0],
            ['draw_name'=> 'Good morning','start_time'=>'16:40 ','end_time'=>'17:00','time_diff'=>'20','visible_time'=>'05:00 pm','active'=>0],
            ['draw_name'=> 'Good morning','start_time'=>'17:00 ','end_time'=>'17:20','time_diff'=>'20','visible_time'=>'05:20 pm','active'=>0],
            ['draw_name'=> 'Good morning','start_time'=>'17:20 ','end_time'=>'17:40','time_diff'=>'20','visible_time'=>'05:40 pm','active'=>0],
            ['draw_name'=> 'Good morning','start_time'=>'17:40 ','end_time'=>'18:00','time_diff'=>'20','visible_time'=>'06:00 pm','active'=>0],
            ['draw_name'=> 'Good morning','start_time'=>'18:00 ','end_time'=>'18:20','time_diff'=>'20','visible_time'=>'06:20 pm','active'=>0],
            ['draw_name'=> 'Good morning','start_time'=>'18:20 ','end_time'=>'18:40','time_diff'=>'20','visible_time'=>'06:40 pm','active'=>0],
            ['draw_name'=> 'Good morning','start_time'=>'18:40 ','end_time'=>'19:00','time_diff'=>'20','visible_time'=>'07:00 pm','active'=>0],
            ['draw_name'=> 'Good morning','start_time'=>'19:00 ','end_time'=>'19:20','time_diff'=>'20','visible_time'=>'07:20 pm','active'=>0],
            ['draw_name'=> 'Good morning','start_time'=>'19:20 ','end_time'=>'19:40','time_diff'=>'20','visible_time'=>'07:40 pm','active'=>0],
            ['draw_name'=> 'Good morning','start_time'=>'19:40 ','end_time'=>'20:00','time_diff'=>'20','visible_time'=>'08:00 pm','active'=>0],
            ['draw_name'=> 'Good morning','start_time'=>'20:00 ','end_time'=>'20:20','time_diff'=>'20','visible_time'=>'08:20 pm','active'=>0],
            ['draw_name'=> 'Good morning','start_time'=>'20:20 ','end_time'=>'20:40','time_diff'=>'20','visible_time'=>'08:40 pm','active'=>0],
            ['draw_name'=> 'Good morning','start_time'=>'20:40 ','end_time'=>'21:00','time_diff'=>'20','visible_time'=>'09:00 pm','active'=>0],
            ['draw_name'=> 'Good morning','start_time'=>'21:00 ','end_time'=>'21:20','time_diff'=>'20','visible_time'=>'09:20 pm','active'=>0],
            ['draw_name'=> 'Good morning','start_time'=>'21:20 ','end_time'=>'21:40','time_diff'=>'20','visible_time'=>'09:40 pm','active'=>0],
            ['draw_name'=> 'Good morning','start_time'=>'21:40 ','end_time'=>'22:00','time_diff'=>'20','visible_time'=>'10:00 pm','active'=>0],


        ]);
        Game::insert([
            ['game_name'=>'Jodi-2D','inforce'=> 1],
            ['game_name'=>'Card','inforce'=> 1]

        ]);

        GameType::insert([
            ['game_id'=>1,'game_type_name'=>'Jodi','game_name'=>'(0.55 * 20)','series_name'=>'A','game_type_initial' => '' ,'mrp'=> 10.00, 'winning_price'=>90, 'winning_bonus_percent'=>0.2, 'commission'=>0.00, 'payout'=>50,'default_payout'=>150],
            ['game_id'=>1,'game_type_name'=>'Jodi','game_name'=>'(0.55 * 20)','series_name'=>'B','game_type_initial' => '' ,'mrp'=> 10.00, 'winning_price'=>90, 'winning_bonus_percent'=>0.2, 'commission'=>0.00, 'payout'=>50,'default_payout'=>150],
            ['game_id'=>1,'game_type_name'=>'Jodi','game_name'=>'(0.55 * 20)','series_name'=>'C','game_type_initial' => '' ,'mrp'=> 10.00, 'winning_price'=>90, 'winning_bonus_percent'=>0.2, 'commission'=>0.00, 'payout'=>50,'default_payout'=>150],
            ['game_id'=>1,'game_type_name'=>'Jodi','game_name'=>'(0.55 * 20)','series_name'=>'D','game_type_initial' => '' ,'mrp'=> 10.00, 'winning_price'=>90, 'winning_bonus_percent'=>0.2, 'commission'=>0.00, 'payout'=>50,'default_payout'=>150],
            ['game_id'=>1,'game_type_name'=>'Jodi','game_name'=>'(0.55 * 20)','series_name'=>'E','game_type_initial' => '' ,'mrp'=> 10.00, 'winning_price'=>90, 'winning_bonus_percent'=>0.2, 'commission'=>0.00, 'payout'=>50,'default_payout'=>150],
            ['game_id'=>2,'game_type_name'=>'Card','game_name'=>'12-card-deck','series_name'=>'','game_type_initial' => '' ,'mrp'=> 10.00, 'winning_price'=>90, 'winning_bonus_percent'=>0.2, 'commission'=>0.00, 'payout'=>50,'default_payout'=>150]

        ]);

        // Product has separate file
        // php artisan db:seed --class=ProductSeeder


        //Transaction types


        //resultMaster

        TwoDigitNumberSets::insert([
            ['number_set'=>'00-09'],
            ['number_set'=>'10-19'],
            ['number_set'=>'20-29'],
            ['number_set'=>'30-39'],
            ['number_set'=>'40-49'],
            ['number_set'=>'50-59'],
            ['number_set'=>'60-69'],
            ['number_set'=>'70-79'],
            ['number_set'=>'80-89'],
            ['number_set'=>'90-99'],
        ]);

        TwoDigitNumberCombinations::insert([
            ['two_digit_number_set_id'=>1,'visible_number'=>'00'],
            ['two_digit_number_set_id'=>1,'visible_number'=>'01'],
            ['two_digit_number_set_id'=>1,'visible_number'=>'02'],
            ['two_digit_number_set_id'=>1,'visible_number'=>'03'],
            ['two_digit_number_set_id'=>1,'visible_number'=>'04'],
            ['two_digit_number_set_id'=>1,'visible_number'=>'05'],
            ['two_digit_number_set_id'=>1,'visible_number'=>'06'],
            ['two_digit_number_set_id'=>1,'visible_number'=>'07'],
            ['two_digit_number_set_id'=>1,'visible_number'=>'08'],
            ['two_digit_number_set_id'=>1,'visible_number'=>'09'],

            ['two_digit_number_set_id'=>2,'visible_number'=>'10'],
            ['two_digit_number_set_id'=>2,'visible_number'=>'11'],
            ['two_digit_number_set_id'=>2,'visible_number'=>'12'],
            ['two_digit_number_set_id'=>2,'visible_number'=>'13'],
            ['two_digit_number_set_id'=>2,'visible_number'=>'14'],
            ['two_digit_number_set_id'=>2,'visible_number'=>'15'],
            ['two_digit_number_set_id'=>2,'visible_number'=>'16'],
            ['two_digit_number_set_id'=>2,'visible_number'=>'17'],
            ['two_digit_number_set_id'=>2,'visible_number'=>'18'],
            ['two_digit_number_set_id'=>2,'visible_number'=>'19'],

            ['two_digit_number_set_id'=>3,'visible_number'=>'20'],
            ['two_digit_number_set_id'=>3,'visible_number'=>'21'],
            ['two_digit_number_set_id'=>3,'visible_number'=>'22'],
            ['two_digit_number_set_id'=>3,'visible_number'=>'23'],
            ['two_digit_number_set_id'=>3,'visible_number'=>'24'],
            ['two_digit_number_set_id'=>3,'visible_number'=>'25'],
            ['two_digit_number_set_id'=>3,'visible_number'=>'26'],
            ['two_digit_number_set_id'=>3,'visible_number'=>'27'],
            ['two_digit_number_set_id'=>3,'visible_number'=>'28'],
            ['two_digit_number_set_id'=>3,'visible_number'=>'29'],

            ['two_digit_number_set_id'=>4,'visible_number'=>'30'],
            ['two_digit_number_set_id'=>4,'visible_number'=>'31'],
            ['two_digit_number_set_id'=>4,'visible_number'=>'32'],
            ['two_digit_number_set_id'=>4,'visible_number'=>'33'],
            ['two_digit_number_set_id'=>4,'visible_number'=>'34'],
            ['two_digit_number_set_id'=>4,'visible_number'=>'35'],
            ['two_digit_number_set_id'=>4,'visible_number'=>'36'],
            ['two_digit_number_set_id'=>4,'visible_number'=>'37'],
            ['two_digit_number_set_id'=>4,'visible_number'=>'38'],
            ['two_digit_number_set_id'=>4,'visible_number'=>'39'],

            ['two_digit_number_set_id'=>5,'visible_number'=>'40'],
            ['two_digit_number_set_id'=>5,'visible_number'=>'41'],
            ['two_digit_number_set_id'=>5,'visible_number'=>'42'],
            ['two_digit_number_set_id'=>5,'visible_number'=>'43'],
            ['two_digit_number_set_id'=>5,'visible_number'=>'44'],
            ['two_digit_number_set_id'=>5,'visible_number'=>'45'],
            ['two_digit_number_set_id'=>5,'visible_number'=>'46'],
            ['two_digit_number_set_id'=>5,'visible_number'=>'47'],
            ['two_digit_number_set_id'=>5,'visible_number'=>'48'],
            ['two_digit_number_set_id'=>5,'visible_number'=>'49'],

            ['two_digit_number_set_id'=>6,'visible_number'=>'50'],
            ['two_digit_number_set_id'=>6,'visible_number'=>'51'],
            ['two_digit_number_set_id'=>6,'visible_number'=>'52'],
            ['two_digit_number_set_id'=>6,'visible_number'=>'53'],
            ['two_digit_number_set_id'=>6,'visible_number'=>'54'],
            ['two_digit_number_set_id'=>6,'visible_number'=>'55'],
            ['two_digit_number_set_id'=>6,'visible_number'=>'56'],
            ['two_digit_number_set_id'=>6,'visible_number'=>'57'],
            ['two_digit_number_set_id'=>6,'visible_number'=>'58'],
            ['two_digit_number_set_id'=>6,'visible_number'=>'59'],

            ['two_digit_number_set_id'=>7,'visible_number'=>'60'],
            ['two_digit_number_set_id'=>7,'visible_number'=>'61'],
            ['two_digit_number_set_id'=>7,'visible_number'=>'62'],
            ['two_digit_number_set_id'=>7,'visible_number'=>'63'],
            ['two_digit_number_set_id'=>7,'visible_number'=>'64'],
            ['two_digit_number_set_id'=>7,'visible_number'=>'65'],
            ['two_digit_number_set_id'=>7,'visible_number'=>'66'],
            ['two_digit_number_set_id'=>7,'visible_number'=>'67'],
            ['two_digit_number_set_id'=>7,'visible_number'=>'68'],
            ['two_digit_number_set_id'=>7,'visible_number'=>'69'],

            ['two_digit_number_set_id'=>8,'visible_number'=>'70'],
            ['two_digit_number_set_id'=>8,'visible_number'=>'71'],
            ['two_digit_number_set_id'=>8,'visible_number'=>'72'],
            ['two_digit_number_set_id'=>8,'visible_number'=>'73'],
            ['two_digit_number_set_id'=>8,'visible_number'=>'74'],
            ['two_digit_number_set_id'=>8,'visible_number'=>'75'],
            ['two_digit_number_set_id'=>8,'visible_number'=>'76'],
            ['two_digit_number_set_id'=>8,'visible_number'=>'77'],
            ['two_digit_number_set_id'=>8,'visible_number'=>'78'],
            ['two_digit_number_set_id'=>8,'visible_number'=>'79'],

            ['two_digit_number_set_id'=>9,'visible_number'=>'80'],
            ['two_digit_number_set_id'=>9,'visible_number'=>'81'],
            ['two_digit_number_set_id'=>9,'visible_number'=>'82'],
            ['two_digit_number_set_id'=>9,'visible_number'=>'83'],
            ['two_digit_number_set_id'=>9,'visible_number'=>'84'],
            ['two_digit_number_set_id'=>9,'visible_number'=>'85'],
            ['two_digit_number_set_id'=>9,'visible_number'=>'86'],
            ['two_digit_number_set_id'=>9,'visible_number'=>'87'],
            ['two_digit_number_set_id'=>9,'visible_number'=>'88'],
            ['two_digit_number_set_id'=>9,'visible_number'=>'89'],

            ['two_digit_number_set_id'=>10,'visible_number'=>'90'],
            ['two_digit_number_set_id'=>10,'visible_number'=>'91'],
            ['two_digit_number_set_id'=>10,'visible_number'=>'92'],
            ['two_digit_number_set_id'=>10,'visible_number'=>'93'],
            ['two_digit_number_set_id'=>10,'visible_number'=>'94'],
            ['two_digit_number_set_id'=>10,'visible_number'=>'95'],
            ['two_digit_number_set_id'=>10,'visible_number'=>'96'],
            ['two_digit_number_set_id'=>10,'visible_number'=>'97'],
            ['two_digit_number_set_id'=>10,'visible_number'=>'98'],
            ['two_digit_number_set_id'=>10,'visible_number'=>'99'],
        ]);

//       ResultMaster::insert([
//           ['draw_master_id'=>1,'game_date'=>'2021-05-24'],
//           ['draw_master_id'=>2,'game_date'=>'2021-05-24'],
//           ['draw_master_id'=>3,'game_date'=>'2021-05-24'],
//           ['draw_master_id'=>4,'game_date'=>'2021-05-24'],
//           ['draw_master_id'=>5,'game_date'=>'2021-05-24'],
//       ]);
//
//       ResultDetail::insert([
//        ['result_masters_id'=>1,'game_type_id'=>'1','two_digit_number_combination_id'=>1],
//        ['result_masters_id'=>1,'game_type_id'=>'2','two_digit_number_combination_id'=>2],
//        ['result_masters_id'=>1,'game_type_id'=>'3','two_digit_number_combination_id'=>3],
//        ['result_masters_id'=>1,'game_type_id'=>'4','two_digit_number_combination_id'=>4],
//        ['result_masters_id'=>1,'game_type_id'=>'5','two_digit_number_combination_id'=>5],
//
//        ['result_masters_id'=>2,'game_type_id'=>'1','two_digit_number_combination_id'=>6],
//        ['result_masters_id'=>2,'game_type_id'=>'2','two_digit_number_combination_id'=>7],
//        ['result_masters_id'=>2,'game_type_id'=>'3','two_digit_number_combination_id'=>8],
//        ['result_masters_id'=>2,'game_type_id'=>'4','two_digit_number_combination_id'=>9],
//        ['result_masters_id'=>2,'game_type_id'=>'5','two_digit_number_combination_id'=>10],
//
//        ['result_masters_id'=>3,'game_type_id'=>'1','two_digit_number_combination_id'=>11],
//        ['result_masters_id'=>3,'game_type_id'=>'2','two_digit_number_combination_id'=>12],
//        ['result_masters_id'=>3,'game_type_id'=>'3','two_digit_number_combination_id'=>13],
//        ['result_masters_id'=>3,'game_type_id'=>'4','two_digit_number_combination_id'=>14],
//        ['result_masters_id'=>3,'game_type_id'=>'5','two_digit_number_combination_id'=>15],
//
//        ['result_masters_id'=>4,'game_type_id'=>'1','two_digit_number_combination_id'=>16],
//        ['result_masters_id'=>4,'game_type_id'=>'2','two_digit_number_combination_id'=>17],
//        ['result_masters_id'=>4,'game_type_id'=>'3','two_digit_number_combination_id'=>18],
//        ['result_masters_id'=>4,'game_type_id'=>'4','two_digit_number_combination_id'=>19],
//        ['result_masters_id'=>4,'game_type_id'=>'5','two_digit_number_combination_id'=>20],
//
//        ['result_masters_id'=>5,'game_type_id'=>'1','two_digit_number_combination_id'=>21],
//        ['result_masters_id'=>5,'game_type_id'=>'2','two_digit_number_combination_id'=>22],
//        ['result_masters_id'=>5,'game_type_id'=>'3','two_digit_number_combination_id'=>23],
//        ['result_masters_id'=>5,'game_type_id'=>'4','two_digit_number_combination_id'=>24],
//        ['result_masters_id'=>5,'game_type_id'=>'5','two_digit_number_combination_id'=>25],
//
//    ]);

    CardCombination::insert([
        ['rank_name'=>'Jack','suit_name'=>'Club','rank_initial'=>'J'],
        ['rank_name'=>'Jack','suit_name'=>'Diamon','rank_initial'=>'J'],
        ['rank_name'=>'Jack','suit_name'=>'Heart','rank_initial'=>'J'],
        ['rank_name'=>'Jack','suit_name'=>'Spade','rank_initial'=>'J'],

        ['rank_name'=>'Queen','suit_name'=>'Club','rank_initial'=>'Q'],
        ['rank_name'=>'Queen','suit_name'=>'Diamon','rank_initial'=>'Q'],
        ['rank_name'=>'Queen','suit_name'=>'Heart','rank_initial'=>'Q'],
        ['rank_name'=>'Queen','suit_name'=>'Spade','rank_initial'=>'Q'],

        ['rank_name'=>'King','suit_name'=>'Club','rank_initial'=>'K'],
        ['rank_name'=>'King','suit_name'=>'Diamon','rank_initial'=>'K'],
        ['rank_name'=>'King','suit_name'=>'Heart','rank_initial'=>'K'],
        ['rank_name'=>'King','suit_name'=>'Spade','rank_initial'=>'K'],

    ]);

        $this->call(CardDrawMasterSeeder::class);

//    CardDrawMaster::insert([
//
//        //5 min difference
//
//        ['card_draw_name'=> 'Good morning','start_time'=>'12:00','end_time'=>'09:00','time_diff'=>'15','visible_time'=>'09:00 am','active'=>1],
//        ['card_draw_name'=> 'Good morning','start_time'=>'09:00','end_time'=>'09:05','time_diff'=>'15','visible_time'=>'09:15 am','active'=>0],
//        ['card_draw_name'=> 'Good afternoon','start_time'=>'09:05','end_time'=>'09:10','time_diff'=>'15','visible_time'=>'09:30 am','active'=>0],
//        ['card_draw_name'=> 'Good evening','start_time'=>'09:10','end_time'=>'09:15','time_diff'=>'15','visible_time'=>'09:45 am','active'=>0],
//        ['card_draw_name'=> 'Lets play','start_time'=>'09:15','end_time'=>'09:20','time_diff'=>'15','visible_time'=>'10:00 am','active'=>0],
//
//
//
//    ]);

        NextGameDraw::create(['next_draw_id' => 2, 'last_draw_id' => 1, 'game_id' => 1]);
        NextGameDraw::create(['next_draw_id' => 2, 'last_draw_id' => 1, 'game_id' => 2]);

        Message::create(['message' =>'test message']);
    }
}
