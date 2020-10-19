<?php

use App\Models\Menu;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UserSeeder::class);

        $users = [
            [
                'id' => 1,
                'name' => 'mukul',
                'mobile' => '01734183130',
                'username' => 'mukul',
                'email' => 'mukul@gmail.com',
                'email_verified_at' => null,
                'password' => bcrypt(123456),
                'remember_token' => null,
                'last_login' => date('Y-m-d H:i:s'),
                'status' => 'active',
                'created_by' => 1
            ],
            [
                'id' => 2,
                'name' => 'cloudly',
                'mobile' => '01734183130',
                'username' => 'cloudly',
                'email' => 'cloudly@gmail.com',
                'email_verified_at' => null,
                'password' => bcrypt(123456),
                'remember_token' => null,
                'last_login' => date('Y-m-d H:i:s'),
                'status' => 'active',
                'created_by' => 1
            ],
            [
                'id' => 3,
                'name' => 'student',
                'mobile' => '01734183130',
                'username' => 'student',
                'email' => 'student@gmail.com',
                'email_verified_at' => null,
                'password' => bcrypt(123456),
                'remember_token' => null,
                'last_login' => date('Y-m-d H:i:s'),
                'status' => 'active',
                'created_by' => 1
            ]

        ];

        \App\Models\User::insert($users);

        $roles = [
            [
                'name' => 'System Admin',
                'slug' => 'system_admin',
                'created_at' => date('Y-m-d H:i:s'),
                'status' => 'active',
                'created_by' => 1
            ],
            [
                'name' => 'Admin',
                'slug' => 'admin',
                'created_at' => date('Y-m-d H:i:s'),
                'status' => 'active',
                'created_by' => 1
            ],
            [
                'name' => 'Student',
                'slug' => 'student',
                'created_at' => date('Y-m-d H:i:s'),
                'status' => 'active',
                'created_by' => 1
            ]

        ];

        \App\Models\Role::insert($roles);

        $permissions = [
            [
                'name' => 'User List',
                'slug' => 'user_list',
                'created_at' => date('Y-m-d H:i:s'),
                'status' => 'active',
                'created_by' => 1
            ],
            [
                'name' => 'User Add',
                'slug' => 'user_add',
                'created_at' => date('Y-m-d H:i:s'),
                'status' => 'active',
                'created_by' => 1
            ],
            [
                'name' => 'User Edit',
                'slug' => 'user_edit',
                'created_at' => date('Y-m-d H:i:s'),
                'status' => 'active',
                'created_by' => 1
            ],
            [
                'name' => 'User Delete',
                'slug' => 'user_delete',
                'created_at' => date('Y-m-d H:i:s'),
                'status' => 'active',
                'created_by' => 1
            ],

            //permission
            [
                'name' => 'Permission List',
                'slug' => 'permission_list',
                'created_at' => date('Y-m-d H:i:s'),
                'status' => 'active',
                'created_by' => 1
            ],
            [
                'name' => 'Permission Add',
                'slug' => 'permission_add',
                'created_at' => date('Y-m-d H:i:s'),
                'status' => 'active',
                'created_by' => 1
            ],
            [
                'name' => 'Permission Edit',
                'slug' => 'permission_edit',
                'created_at' => date('Y-m-d H:i:s'),
                'status' => 'active',
                'created_by' => 1
            ],
            [
                'name' => 'Permission Delete',
                'slug' => 'permission_delete',
                'created_at' => date('Y-m-d H:i:s'),
                'status' => 'active',
                'created_by' => 1
            ],

            //Role
            [
                'name' => 'Role List',
                'slug' => 'role_list',
                'created_at' => date('Y-m-d H:i:s'),
                'status' => 'active',
                'created_by' => 1
            ],
            [
                'name' => 'Role Add',
                'slug' => 'role_add',
                'created_at' => date('Y-m-d H:i:s'),
                'status' => 'active',
                'created_by' => 1
            ],
            [
                'name' => 'Role Edit',
                'slug' => 'role_edit',
                'created_at' => date('Y-m-d H:i:s'),
                'status' => 'active',
                'created_by' => 1
            ],
            [
                'name' => 'Role Delete',
                'slug' => 'role_delete',
                'created_at' => date('Y-m-d H:i:s'),
                'status' => 'active',
                'created_by' => 1
            ],

            //subject
            [
                'name' => 'Subject List',
                'slug' => 'subject_list',
                'created_at' => date('Y-m-d H:i:s'),
                'status' => 'active',
                'created_by' => 1
            ],
            [
                'name' => 'Subject Add',
                'slug' => 'subject_add',
                'created_at' => date('Y-m-d H:i:s'),
                'status' => 'active',
                'created_by' => 1
            ],
            [
                'name' => 'Subject Edit',
                'slug' => 'subject_edit',
                'created_at' => date('Y-m-d H:i:s'),
                'status' => 'active',
                'created_by' => 1
            ],
            [
                'name' => 'Subject Delete',
                'slug' => 'subject_delete',
                'created_at' => date('Y-m-d H:i:s'),
                'status' => 'active',
                'created_by' => 1
            ],

            //question
            [
                'name' => 'Question List',
                'slug' => 'question_list',
                'created_at' => date('Y-m-d H:i:s'),
                'status' => 'active',
                'created_by' => 1
            ],
            [
                'name' => 'Question Add',
                'slug' => 'question_add',
                'created_at' => date('Y-m-d H:i:s'),
                'status' => 'active',
                'created_by' => 1
            ],
            [
                'name' => 'Question Edit',
                'slug' => 'question_edit',
                'created_at' => date('Y-m-d H:i:s'),
                'status' => 'active',
                'created_by' => 1
            ],
            [
                'name' => 'Question Delete',
                'slug' => 'question_delete',
                'created_at' => date('Y-m-d H:i:s'),
                'status' => 'active',
                'created_by' => 1
            ],

            //Exam
            [
                'name' => 'Exam List',
                'slug' => 'exam_list',
                'created_at' => date('Y-m-d H:i:s'),
                'status' => 'active',
                'created_by' => 1
            ],
            [
                'name' => 'Exam Add',
                'slug' => 'exam_add',
                'created_at' => date('Y-m-d H:i:s'),
                'status' => 'active',
                'created_by' => 1
            ],
            [
                'name' => 'Exam Edit',
                'slug' => 'exam_edit',
                'created_at' => date('Y-m-d H:i:s'),
                'status' => 'active',
                'created_by' => 1
            ],
            [
                'name' => 'Exam Delete',
                'slug' => 'exam_delete',
                'created_at' => date('Y-m-d H:i:s'),
                'status' => 'active',
                'created_by' => 1
            ],

            //Exam-paper
            [
                'name' => 'Exam paper List',
                'slug' => 'exam_paper_list',
                'created_at' => date('Y-m-d H:i:s'),
                'status' => 'active',
                'created_by' => 1
            ],
            [
                'name' => 'Exam paper Add',
                'slug' => 'exam_paper_add',
                'created_at' => date('Y-m-d H:i:s'),
                'status' => 'active',
                'created_by' => 1
            ],
            [
                'name' => 'Exam paper Edit',
                'slug' => 'exam_paper_edit',
                'created_at' => date('Y-m-d H:i:s'),
                'status' => 'active',
                'created_by' => 1
            ],
            [
                'name' => 'Exam paper Delete',
                'slug' => 'exam_paper_delete',
                'created_at' => date('Y-m-d H:i:s'),
                'status' => 'active',
                'created_by' => 1
            ],

            //assign
            [
                'name' => 'Assign List',
                'slug' => 'assign_list',
                'created_at' => date('Y-m-d H:i:s'),
                'status' => 'active',
                'created_by' => 1
            ],
            [
                'name' => 'Assign Add',
                'slug' => 'assign_add',
                'created_at' => date('Y-m-d H:i:s'),
                'status' => 'active',
                'created_by' => 1
            ],
            [
                'name' => 'Assign Edit',
                'slug' => 'assign_edit',
                'created_at' => date('Y-m-d H:i:s'),
                'status' => 'active',
                'created_by' => 1
            ],
            [
                'name' => 'Assign Delete',
                'slug' => 'assign_delete',
                'created_at' => date('Y-m-d H:i:s'),
                'status' => 'active',
                'created_by' => 1
            ],

            //test
            [
                'name' => 'test',
                'slug' => 'test',
                'created_at' => date('Y-m-d H:i:s'),
                'status' => 'active',
                'created_by' => 1
            ]

        ];

        \App\Models\Permission::insert($permissions);

        $rolePermission = [
            ['role_id' => 1, 'permission_id' => 1],
            ['role_id' => 1, 'permission_id' => 2],
            ['role_id' => 1, 'permission_id' => 3],
            ['role_id' => 1, 'permission_id' => 4],
            ['role_id' => 1, 'permission_id' => 5],
            ['role_id' => 1, 'permission_id' => 6],
            ['role_id' => 1, 'permission_id' => 7],
            ['role_id' => 1, 'permission_id' => 8],
            ['role_id' => 1, 'permission_id' => 9],
            ['role_id' => 1, 'permission_id' => 10],
            ['role_id' => 1, 'permission_id' => 11],
            ['role_id' => 1, 'permission_id' => 12],
            ['role_id' => 1, 'permission_id' => 13],
            ['role_id' => 1, 'permission_id' => 14],
            ['role_id' => 1, 'permission_id' => 15],
            ['role_id' => 1, 'permission_id' => 16],
            ['role_id' => 1, 'permission_id' => 17],
            ['role_id' => 1, 'permission_id' => 18],
            ['role_id' => 1, 'permission_id' => 19],
            ['role_id' => 1, 'permission_id' => 20],
            ['role_id' => 1, 'permission_id' => 21],
            ['role_id' => 1, 'permission_id' => 22],
            ['role_id' => 1, 'permission_id' => 23],
            ['role_id' => 1, 'permission_id' => 24],
            ['role_id' => 1, 'permission_id' => 25],
            ['role_id' => 1, 'permission_id' => 26],
            ['role_id' => 1, 'permission_id' => 27],
            ['role_id' => 1, 'permission_id' => 28],
            ['role_id' => 1, 'permission_id' => 29],
            ['role_id' => 1, 'permission_id' => 30],
            ['role_id' => 1, 'permission_id' => 31],
            ['role_id' => 1, 'permission_id' => 32],

            ['role_id' => 2, 'permission_id' => 13],
            ['role_id' => 2, 'permission_id' => 14],
            ['role_id' => 2, 'permission_id' => 15],
            ['role_id' => 2, 'permission_id' => 16],
            ['role_id' => 2, 'permission_id' => 17],
            ['role_id' => 2, 'permission_id' => 18],
            ['role_id' => 2, 'permission_id' => 19],
            ['role_id' => 2, 'permission_id' => 20],
            ['role_id' => 2, 'permission_id' => 21],
            ['role_id' => 2, 'permission_id' => 22],
            ['role_id' => 2, 'permission_id' => 23],
            ['role_id' => 2, 'permission_id' => 24],
            ['role_id' => 2, 'permission_id' => 25],
            ['role_id' => 2, 'permission_id' => 26],
            ['role_id' => 2, 'permission_id' => 27],
            ['role_id' => 2, 'permission_id' => 28],
            ['role_id' => 2, 'permission_id' => 29],
            ['role_id' => 2, 'permission_id' => 30],
            ['role_id' => 2, 'permission_id' => 31],

            ['role_id' => 3, 'permission_id' => 33],

        ];

        \App\Models\RolePermission::insert($rolePermission);

        $userPermission = [
            'user_id' => 1,
            'permission_id' => 1
        ];

        \App\Models\UserPermission::create($userPermission);

        $userRole = [
            [
                'user_id' => 1,
                'role_id' => 1
            ],
            [
                'user_id' => 2,
                'role_id' => 2
            ],
            [
                'user_id' => 3,
                'role_id' => 3
            ],
        ];

        \App\Models\UserRole::insert($userRole);

        //MENU
        Menu::insert([
            ['name'=>'Dashboard', 'slug'=> 'dashboard', 'route' =>'home', 'created_by' =>1, 'created_at'=> date('Y-m-d') ],
            ['name'=>'User Management', 'slug'=> 'user_management', 'route' =>'users.index', 'created_by' =>1, 'created_at'=> date('Y-m-d') ],
            ['name'=>'Subject', 'slug'=> 'subject', 'route' =>'subjects.index', 'created_by' =>1, 'created_at'=> date('Y-m-d') ],
            ['name'=>'Question', 'slug'=> 'question', 'route' =>'questions.index', 'created_by' =>1, 'created_at'=> date('Y-m-d') ],
            ['name'=>'Exam', 'slug'=> 'exam', 'route' =>'exams.index', 'created_by' =>1, 'created_at'=> date('Y-m-d') ],
            ['name'=>'Exam Paper', 'slug'=> 'exam_paper', 'route' =>'question-papers.index', 'created_by' =>1, 'created_at'=> date('Y-m-d') ],
            ['name'=>'Question Assign', 'slug'=> 'question_assign', 'route' =>'question-assigns.index', 'created_by' =>1, 'created_at'=> date('Y-m-d') ],
            ['name'=>'Test', 'slug'=> 'test', 'route' =>'tests.index', 'created_by' =>1, 'created_at'=> date('Y-m-d') ],
        ]);


        $roleMenu = [
            ['role_id' => 1, 'menu_id' => 1 ],
            ['role_id' => 1, 'menu_id' => 2 ],
            ['role_id' => 1, 'menu_id' => 3 ],
            ['role_id' => 1, 'menu_id' => 4 ],
            ['role_id' => 1, 'menu_id' => 5 ],
            ['role_id' => 1, 'menu_id' => 6 ],
            ['role_id' => 1, 'menu_id' => 7 ],

            ['role_id' => 2, 'menu_id' => 3 ],
            ['role_id' => 2, 'menu_id' => 4],
            ['role_id' => 2, 'menu_id' => 5],
            ['role_id' => 2, 'menu_id' => 6],
            ['role_id' => 2, 'menu_id' => 7 ],

            ['role_id' => 3, 'menu_id' => 8 ],


        ];

        \App\Models\RoleMenu::insert($roleMenu);
    }
}
