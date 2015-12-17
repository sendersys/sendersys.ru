<?php

use Illuminate\Database\Seeder;

class MainPageTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('main_page')->insert([

            'first_string' => '������� ������ ����������� ������� ���</br> ���������� �������� ����� email',
            'second_string' => '��������� ����������� � ������� ��������</br>��������� �������������� ������ ���������',
            'content_title' => '��� ��� ��������?',
            'first_column_title' => '���������� ����������:',
            'first_column_text' => '<p class = "howwork__list pull-left col-md-10 col-md-offset-1"><span class = "point">� </span> �� �������������� ��� ������ � �� ����� �������� �������� ����� �����������.</p>
</br>
<p class = "howwork__list pull-left col-md-10 col-md-offset-1">�  �� ������ ��������� � ���� ������� ����������� ����������� � ������ �������� �� ���.</p>',
            'second_column_title' => '�������� ������:��������',
            'second_column_text' => '<p class = "howwork__list pull-left col-md-10 col-md-offset-1"><span class = "point">� </span> �������� ������ � ��������� ���� �������� �� �������.</p>
</br>
<p class = "howwork__list pull-left col-md-10 col-md-offset-1">�  ������� ������� �������� � ��������� ���� �����, � ��� ��������� ������ ��������� �� ������ ������ �������.</p>',
            'first_footer_string' => '��� �������� ����� ������ � ����� ����������!</br>���������� ����',
            'active' => '1',

        ]);
    }
}
