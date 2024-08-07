<?php

namespace Modules\Authentication\Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Modules\Authentication\Enums\Sex;
use Modules\Authentication\Models\Character;
use Spatie\Permission\Models\Role;

class CharacterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $charachters = [
            'Visionary Leader' => ['scores' =>  ['problem_solving' => 'heigh', 'leadership' => 'heigh', 'self_magment' => 'low', 'ai_and_tech' => 'low'], 'desc' => 'Excels in problem-solving and leadership. Needs improvement in self-management and tech skills.'],
            'Strategic Leader' => ['scores' =>  ['problem_solving' => 'heigh', 'leadership' => 'medium', 'self_magment' => 'low', 'ai_and_tech' => 'low'], 'desc' => 'Strong in problem-solving with medium leadership. Needs improvement in self-management and tech skills.'],
            'Self-Reliant Leader' => ['scores' =>  ['problem_solving' => 'heigh', 'leadership' => 'low', 'self_magment' => 'heigh', 'ai_and_tech' => 'low'], 'desc' => 'Excels in problem-solving and self-management. Needs improvement in leadership and tech skills.'],
            'Balanced Leader' => ['scores' =>  ['problem_solving' => 'heigh', 'leadership' => 'low', 'self_magment' => 'medium', 'ai_and_tech' => 'low'], 'desc' => 'Strong in problem-solving with medium self-management. Needs improvement in leadership and tech skills.'],
            'Tech-Savvy Leader' => ['scores' =>  ['problem_solving' => 'heigh', 'leadership' => 'low', 'self_magment' => 'low', 'ai_and_tech' => 'heigh'], 'desc' => 'Excels in problem-solving and AI & technology. Needs improvement in leadership and self-management.'],
            'Innovative Leader' => ['scores' =>  ['problem_solving' => 'high', 'leadership' => 'low', 'self_magment' => 'low', 'ai_and_tech' => 'medium'], 'desc' => 'Strong in problem-solving with medium AI & technology. Needs improvement in leadership and self-management.'],
            'Inspiring Leader' => ['scores' =>  ['problem_solving' => 'medium', 'leadership' => 'heigh', 'self_magment' => 'low', 'ai_and_tech' => 'low'], 'desc' => 'Strong in leadership with medium problem-solving. Needs improvement in self-management and tech skills.'],
            'Inspiring Leader' => ['scores' =>  ['problem_solving' => 'medium', 'leadership' => 'heigh', 'self_magment' => 'low', 'ai_and_tech' => 'low'], 'desc' => 'Strong in leadership with medium problem-solving. Needs improvement in self-management and tech skills.'],
            'Practical Leader' => ['scores' =>  ['problem_solving' => 'medium', 'leadership' => 'medium', 'self_magment' => 'low', 'ai_and_tech' => 'low'], 'desc' => 'Balanced in leadership and problem-solving. Needs improvement in self-management and tech skills.'],
            'Tech Leader' => ['scores' =>  ['problem_solving' => 'medium', 'leadership' => 'low', 'self_magment' => 'medium', 'ai_and_tech' => 'low'], 'desc' => 'Balanced in leadership with high self-management. Needs improvement in problem-solving and tech skills.'],
            'Analytical Leader' => ['scores' =>  ['problem_solving' => 'medium', 'leadership' => 'low', 'self_magment' => 'medium', 'ai_and_tech' => 'low'], 'desc' => 'Balanced in leadership with medium self-management. Needs improvement in problem-solving and tech skills.'],
            'Comprehensive Leader' => ['scores' =>  ['problem_solving' => 'medium', 'leadership' => 'low', 'self_magment' => 'low', 'ai_and_tech' => 'heigh'], 'desc' => 'Balanced in leadership with high AI & technology. Needs improvement in problem-solving and self-management.'],
            'Balanced Strategist' => ['scores' =>  ['problem_solving' => 'medium', 'leadership' => 'low', 'self_magment' => 'low', 'ai_and_tech' => 'medium'], 'desc' => 'Balanced in leadership with medium AI & technology. Needs improvement in problem-solving and self-management.'],
            'Visionary Self-Manager' => ['scores' =>  ['problem_solving' => 'low', 'leadership' => 'high', 'self_magment' => 'low', 'ai_and_tech' => 'low'], 'desc' => 'Strong in self-management with medium leadership. Needs improvement in problem-solving and tech skills.'],
            'Practical Self-Manager' => ['scores' =>  ['problem_solving' => 'low', 'leadership' => 'medium', 'self_magment' => 'low', 'ai_and_tech' => 'low'], 'desc' => 'Balanced in self-management and leadership. Needs improvement in problem-solving and tech skills.'],
            'Comprehensive Self-Manager' => ['scores' =>  ['problem_solving' => 'low', 'leadership' => 'low', 'self_magment' => 'high', 'ai_and_tech' => 'low'], 'desc' => 'Excels in self-management. Needs improvement in leadership and problem-solving.'],
            'Balanced Self-Manager' => ['scores' =>  ['problem_solving' => 'low', 'leadership' => 'low', 'self_magment' => 'medium', 'ai_and_tech' => 'low'], 'desc' => 'Balanced in self-management and problem-solving. Needs improvement in leadership and tech skills.'],
            'Visionary Technologist' => ['scores' =>  ['problem_solving' => 'low', 'leadership' => 'low', 'self_magment' => 'low', 'ai_and_tech' => 'high'], 'desc' => 'Excels in AI & technology. Needs improvement in leadership and problem-solving.'],
            'Analytical Technologist' => ['scores' =>  ['problem_solving' => 'low', 'leadership' => 'low', 'self_magment' => 'low', 'ai_and_tech' => 'medium'], 'desc' => 'Balanced in AI & technology. Needs improvement in leadership and problem-solving.'],
            'Balanced Individual' => ['scores' =>  ['problem_solving' => 'medium', 'leadership' => 'medium', 'self_magment' => 'medium', 'ai_and_tech' => 'medium'], 'desc' => 'Balanced in all areas.'],
            'Generalist' => ['scores' =>  ['problem_solving' => 'low', 'leadership' => 'low', 'self_magment' => 'low', 'ai_and_tech' => 'low'], 'desc' => 'Needs improvement in all areas.'],
            'Empathetic Strategist' => ['scores' =>  ['problem_solving' => 'high', 'leadership' => 'high', 'self_magment' => 'medium', 'ai_and_tech' => 'low'], 'desc' => 'The Empathetic Strategist is a well-rounded leader excelling in problem-solving and people skills. This character style is marked by a strong ability to connect with and inspire others, making them effective in leadership roles. While their self-management skills are developing, they possess the ability to maintain a balanced approach to their tasks and responsibilities. Despite a lower proficiency in AI and technology, the Empathetic Strategist uses their strategic thinking and interpersonal skills to navigate challenges and drive success through collaborative and human-centric approaches.'],
            'Visionary Innovator' => ['scores' =>  ['problem_solving' => 'high', 'leadership' => 'high', 'self_magment' => 'low', 'ai_and_tech' => 'high'], 'desc' => 'The Visionary Innovator thrives at the intersection of problem-solving, leadership, and technology. This character style embodies a blend of strategic thinking and forward-looking insight, making them capable of envisioning and driving transformative changes. With a strong aptitude for AI and technology, the Visionary Innovator not only solves complex problems but also leads teams with charisma and inspiration. Despite a current low in self-management skills, this individual has the potential to balance these traits, harnessing their tech-savvy nature and leadership prowess to excel in dynamic environments.'],
            'Harmonious Strategist' => ['scores' =>  ['problem_solving' => 'medium', 'leadership' => 'high', 'self_magment' => 'high', 'ai_and_tech' => 'medium'], 'desc' => 'The Harmonious Strategist is a well-rounded individual who excels in leadership and people skills while maintaining a high level of self-management. This character style is marked by a strong ability to connect with and inspire others, making them highly effective in leadership roles. With a medium proficiency in problem-solving and technology, the Harmonious Strategist uses a strategic and collaborative approach to overcome challenges and drive success. Their ability to manage tasks efficiently and maintain balance in their professional and personal life is a key strength'],
            'Innovative Problem Solver' => ['scores' =>  ['problem_solving' => 'high', 'leadership' => 'medium', 'self_magment' => 'high', 'ai_and_tech' => 'high'], 'desc' => 'Excels in problem-solving and self-management with medium leadership. Needs improvement in tech skills.'],
        ];

        foreach ($charachters as $title => $charachter) {
            Character::updateOrCreate(
                ['title' => $title],
                [
                    "ai_and_tech" => $charachter['scores']['ai_and_tech'],
                    "self_managment" => $charachter['scores']['self_magment'],
                    "problem_solving" => $charachter['scores']['problem_solving'],
                    "leader_ship_and_pepple_skills" => $charachter['scores']['leadership'],
                    'desc' => $charachter['desc'],
                ]
            );
        }
    }
}
