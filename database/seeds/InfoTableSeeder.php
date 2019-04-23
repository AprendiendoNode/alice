<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

use App\User;
use App\Section;
use App\Menu;
use Carbon\Carbon;

class InfoTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run()
    {
      Role::truncate();
      User::truncate();

      //Creamos los roles predeterminados
      $superadminRole = Role::create(['name' => 'SuperAdmin']);
           $adminRole = Role::create(['name' => 'Admin']);
        $operatorRole = Role::create(['name' => 'Operator']);
            $userRole = Role::create(['name' => 'UserRole']);
         $monitorRole = Role::create(['name' => 'Monitor']);
         $surveyedRole = Role::create(['name' => 'Surveyed']);
         $conciergeRole = Role::create(['name' => 'Itconcierge']);

      //Creamos los permissions predeterminados
      $permisos_001= Permission::create(['name' => 'View dashboard pral']);
      $permisos_002= Permission::create(['name' => 'View detailed for hotel']);
      $permisos_003= Permission::create(['name' => 'View detailed for proyect']);
      $permisos_004= Permission::create(['name' => 'View cover']);
      $permisos_005= Permission::create(['name' => 'View distribucion']);
      $permisos_006= Permission::create(['name' => 'View add equipment']);
      $permisos_007= Permission::create(['name' => 'Create equipment']);
      $permisos_008= Permission::create(['name' => 'View removed equipment']);
      $permisos_009= Permission::create(['name' => 'Removed equipment']);
      $permisos_010= Permission::create(['name' => 'View search equipment']);
      $permisos_011= Permission::create(['name' => 'View move equipment']);
      $permisos_012= Permission::create(['name' => 'Move equipment']);
      $permisos_013= Permission::create(['name' => 'View equipment group']);
      $permisos_014= Permission::create(['name' => 'Add equipment group']);
      $permisos_015= Permission::create(['name' => 'Removed equipment group']);
      $permisos_016= Permission::create(['name' => 'View assign report']);
      $permisos_017= Permission::create(['name' => 'Create assign report']);
      $permisos_018= Permission::create(['name' => 'Delete assign report']);
      $permisos_019= Permission::create(['name' => 'View individual capture']);
      $permisos_020= Permission::create(['name' => 'View individual general report']);
      $permisos_021= Permission::create(['name' => 'View report']);
      $permisos_022= Permission::create(['name' => 'View report concat']);
      $permisos_023= Permission::create(['name' => 'Create user nps']);
      $permisos_024= Permission::create(['name' => 'Edit individual general report']);
      $permisos_025= Permission::create(['name' => 'Create general report']);
      $permisos_026= Permission::create(['name' => 'Create individual capture']);
      $permisos_027= Permission::create(['name' => 'Option admin approval']);
      $permisos_028= Permission::create(['name' => 'Notification admin approval']);
      $permisos_029= Permission::create(['name' => 'View provider']);
      $permisos_030= Permission::create(['name' => 'Create provider']);
      $permisos_031= Permission::create(['name' => 'Edit provider']);
      $permisos_032= Permission::create(['name' => 'Delete provider']);
      $permisos_033= Permission::create(['name' => 'View dashboard survey nps']);
      $permisos_034= Permission::create(['name' => 'View create survey']);
      $permisos_035= Permission::create(['name' => 'Generate survey']);
      $permisos_036= Permission::create(['name' => 'View capture survey']);
      $permisos_037= Permission::create(['name' => 'Create survey']);
      $permisos_038= Permission::create(['name' => 'View edit survey']);
      $permisos_039= Permission::create(['name' => 'Edit survey']);
      $permisos_040= Permission::create(['name' => 'View results survey']);
      $permisos_041= Permission::create(['name' => 'View survey configuration']);
      $permisos_042= Permission::create(['name' => 'Assign user survey']);
      $permisos_043= Permission::create(['name' => 'Removed user survey']);
      $permisos_044= Permission::create(['name' => 'Generate key user survey']);
      $permisos_045= Permission::create(['name' => 'Send email user survey']);
      $permisos_046= Permission::create(['name' => 'View key user survey']);

      $permisos_047= Permission::create(['name' => 'View survey nps configuration']);
      $permisos_048= Permission::create(['name' => 'View assign hotel user']);
      $permisos_049= Permission::create(['name' => 'Create assign hotel user']);
      $permisos_050= Permission::create(['name' => 'Delete assign hotel user']);
      $permisos_051= Permission::create(['name' => 'View list assign hotel user']);
      $permisos_052= Permission::create(['name' => 'View assign delete client']);
      $permisos_053= Permission::create(['name' => 'View config nps automatic']);
      $permisos_054= Permission::create(['name' => 'Create config nps automatic']);
      $permisos_055= Permission::create(['name' => 'View config nps individual']);
      $permisos_056= Permission::create(['name' => 'Create config nps individual']);
      $permisos_057= Permission::create(['name' => 'View guest review']);
      $permisos_058= Permission::create(['name' => 'View server review']);
      $permisos_059= Permission::create(['name' => 'View test zd']);
      $permisos_060= Permission::create(['name' => 'Create user']);
      $permisos_061= Permission::create(['name' => 'Edit user']);
      $permisos_062= Permission::create(['name' => 'Delete user']);
      $permisos_063= Permission::create(['name' => 'View Configuration']);
      $permisos_064= Permission::create(['name' => 'Edit Configuration']);
      $permisos_065= Permission::create(['name' => 'View dashboard sitwifi']);
      $permisos_066= Permission::create(['name' => 'View config sitwifi']);
      $permisos_067= Permission::create(['name' => 'Create config sitwifi']);
      $permisos_068= Permission::create(['name' => 'Send mail sitwifi']);
      $permisos_069= Permission::create(['name' => 'Create model']);
      $permisos_070= Permission::create(['name' => 'Create marcas']);
      $permisos_071= Permission::create(['name' => 'View dashboard travel expenses']);
      $permisos_072= Permission::create(['name' => 'View add request of travel expenses']);
      $permisos_073= Permission::create(['name' => 'View history travel requests']);
      $permisos_074= Permission::create(['name' => 'Create add request of travel expenses']);
      $permisos_075= Permission::create(['name' => 'Edit request of travel expenses']);
      $permisos_076= Permission::create(['name' => 'Checking request of travel expenses']);
      $permisos_077= Permission::create(['name' => 'Reuse request of travel expenses']);
      $permisos_078= Permission::create(['name' => 'Approve request of travel expenses']);
      $permisos_079= Permission::create(['name' => 'Travel allowance notification']);

      $permisos_080= Permission::create(['name' => 'View level zero notifications']);
      $permisos_081= Permission::create(['name' => 'View level one notifications']);
      $permisos_082= Permission::create(['name' => 'View level two notifications']);
      $permisos_083= Permission::create(['name' => 'View level three notifications']);
      $permisos_084= Permission::create(['name' => 'View level four notifications']);
      $permisos_085= Permission::create(['name' => 'Create grupos']);
      $permisos_087= Permission::create(['name' => 'View group letter']);
      $permisos_088= Permission::create(['name' => 'View cover delivery']);
      $permisos_089= Permission::create(['name' => 'View add request of payment']);

      $permisos_090= Permission::create(['name' => 'View history of payment']);
      $permisos_091= Permission::create(['name' => 'View requests via']);
      $permisos_092= Permission::create(['name' => 'View history all viatic']);
      $permisos_093= Permission::create(['name' => 'Deny travel allowance request']);
      $permisos_094= Permission::create(['name' => 'View weekly viatic']);
      $permisos_095= Permission::create(['name' => 'Payment notification']);
      $permisos_096= Permission::create(['name' => 'View level zero payment notification']);
      $permisos_097= Permission::create(['name' => 'View level one payment notification']);
      $permisos_098= Permission::create(['name' => 'View level two payment notification']);
      $permisos_099= Permission::create(['name' => 'View level three payment notification']);

      $permisos_100= Permission::create(['name' => 'View dashboard payment notification']);
      $permisos_101= Permission::create(['name' => 'View history all payment notification']);
      $permisos_102= Permission::create(['name' => 'View filter proyect payment']);
      $permisos_103= Permission::create(['name' => 'View history all payments status paid']);
      $permisos_104= Permission::create(['name' => 'View manage bank account']);
      $permisos_105= Permission::create(['name' => 'Create data bank']);
      $permisos_106= Permission::create(['name' => 'Create data bank provider']);
      $permisos_107= Permission::create(['name' => 'View level program payment notification']);
      $permisos_108= Permission::create(['name' => 'Create id ubicacion']);
      $permisos_109= Permission::create(['name' => 'View add multiple request of payment']);

      $permisos_110= Permission::create(['name' => 'Create data bank by multiple payment']);
      $permisos_111= Permission::create(['name' => 'Create data bank provider by multiple payment']);
      $permisos_112= Permission::create(['name' => 'View program date payment']);
      $permisos_113= Permission::create(['name' => 'View confirm of payment']);
      $permisos_114= Permission::create(['name' => 'View dashboard customer service']);
      $permisos_115= Permission::create(['name' => 'View info my ticket']);
      $permisos_116= Permission::create(['name' => 'View statistics tickets']);
      $permisos_117= Permission::create(['name' => 'View contract dashboard']);
      $permisos_118= Permission::create(['name' => 'View create contract']);
      $permisos_119= Permission::create(['name' => 'View create group by contract']);

      $permisos_120= Permission::create(['name' => 'View create rz by contract']);
      $permisos_121= Permission::create(['name' => 'View edit contract']);
      $permisos_122= Permission::create(['name' => 'View register contract payments']);
      $permisos_123= Permission::create(['name' => 'View the payment history of the contracts']);
      $permisos_124= Permission::create(['name' => 'View drive']);
      $permisos_125= Permission::create(['name' => 'View add invoices by drive']);
      $permisos_126= Permission::create(['name' => 'View management to products']);
      $permisos_127= Permission::create(['name' => 'Management to create products']);
      $permisos_128= Permission::create(['name' => 'Management to read products']);
      $permisos_129= Permission::create(['name' => 'Management to update products']);

      $permisos_130= Permission::create(['name' => 'Management to delete products']);
      $permisos_131= Permission::create(['name' => 'View survey christmas configuration']);
      $permisos_132= Permission::create(['name' => 'View Document P']);
      $permisos_133= Permission::create(['name' => 'View Edit Document P']);
      $permisos_134= Permission::create(['name' => 'View History to Document P']);
      $permisos_135= Permission::create(['name' => 'Update of concepts assigned to travel expenses']);
      $permisos_136= Permission::create(['name' => 'View level zero documentp notification']);
      $permisos_137= Permission::create(['name' => 'View level one documentp notification']);
      $permisos_138= Permission::create(['name' => 'View level two documentp notification']);
      $permisos_139= Permission::create(['name' => 'View level three documentp notification']);

      $permisos_140= Permission::create(['name' => 'View History Auth Document P']);
      $permisos_141= Permission::create(['name' => 'View Reg. Mensual CXC Det']);
      $permisos_142= Permission::create(['name' => 'View Reg. Mensual CXC Aprob']);
      $permisos_143= Permission::create(['name' => 'View delivery documents']);
      $permisos_144= Permission::create(['name' => 'View Reg. Mensual CXC Cobrados']);
      $permisos_145= Permission::create(['name' => 'View projects docp']);
      $permisos_146= Permission::create(['name' => 'View annual budget']);
    }
}
