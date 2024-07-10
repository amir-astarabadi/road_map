<?php

namespace Modules\RoadMap\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\RoadMap\Enums\QuestionCategory;
use Modules\RoadMap\Models\Answer;
use Modules\RoadMap\Models\Career;
use Modules\RoadMap\Models\Question;

class QuestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        if(Question::exists()){
            return;
        }

        $questions = [

            [
                "category" => QuestionCategory::PROBLEM_SOLVING,
                "title" => "How do you start approach solving everyday challenges in your life?",
                "answers" => [
                    3 => "Gathering all relevant information, breaking down the problem into smaller parts,…",
                    2 => "Get advice from people who I know can help me, Synthesis potential solutions,…",
                    1 => "Synthesis potential solutions, customize the related solution to my situation,…",
                ]
            ],

            [
                "category" => QuestionCategory::PROBLEM_SOLVING,
                "title" => "Imagine a situation where you
had to deal with a difficult team
member while working on a
project, what is your approach:
PS: the project is timely and you
have two weeks to complete it
and present it to the CEO of your
organization, and you are the one
who lead the team and results",
                "answers" => [
                    3 => "I organize a one-on-one discussion,
actively listen to their concerns, and found
common ground to adjust our approach
and work together more smoothly.",
                    2 => "Because we have limited time, get him out
of the project and revise our priorities.",
                    1 => "Continue the projects without considering
this issue, because we have limited time
and when we finish the project I will solve
the issue with him.",
                ]
            ],

            [
                "category" => QuestionCategory::PROBLEM_SOLVING,
                "title" => "How do you handle situations
when you encounter resistance to
your proposed solutions?",
                "answers" => [
                    3 => "I try to understand the reasons behind the
resistance, provide data and examples to
support my solution and I’m open to
adjusting my proposal based on
constructive feedback.",
                    2 => "I try to understand the reasons behind the
resistance highlight the benefits.",
                    1 => "I adjust my proposal based on
constructive feedback and try to convince
them why I chose the first solution.",
                ]
            ],

            [
                "category" => QuestionCategory::PROBLEM_SOLVING,
                "title" => "Which tools do you know and
have used so far?
(Brainstorming, Fishbone diagram,
Decision trees, SWOT analysis,
MECE)",
                "answers" => [
                    3 => "If they choose 4 or 5 items.",
                    2 => "If they choose 3 or 2 items.",
                    1 => "If they choose less than 2 items.",
                ]
            ],

            [
                "category" => QuestionCategory::PROBLEM_SOLVING,
                "title" => "You have been appointed as
the head of the office that
allocates funds for promoting
innovations in all walks of life by a
corporation under the CSR
(Corporate Social Responsibility)
scheme. You have received two
proposals and as a rule, you need
to select only one of these. One
organization aims at assisting
people for becoming spiritual
irrespective of religion, caste, or
creed, using innovative yoga
practices. The head of this
organization is the guru of one of
the influential leaders from the city
and he is pressurizing you to
select his proposal. Another
enterprise of young entrepreneurs
wants to develop tools for
sanitation workers who maintain
the city clean on no-profit basis.
With some demonstrations, the
enterprise guarantees that their
tools will help workers to handle all
sort of dirt without getting dirty
and save them from becoming
prone to various diseases. You
will: ",
                "answers" => [
                    3 => "Allocate funds to entrepreneurs’ group as
there is an urgent need for developing
assisting tools for these people as it is their
right to live a healthy and respectful life.",
                    2 => "Allocate the funds for the spiritual
organization as there are many affluent
followers of this guru in the city and
according to them they are doing good
activities for the benefit of wider society. ",
                    1 => "Delay taking any decision as till now you
have not seen spirituality playing any
positive role in eradicating corruption,
injustice, and oppression that is present in
various forms.",
                ]
            ],

            [
                "category" => QuestionCategory::LEADER_SHIP_AND_PEPPLE_SKILLS,
                "title" => "Have you ever had the
experience of leading a team?",
                "answers" => [
                    3 => "Yes, for more than 3 years",
                    2 => "Yes, for less than 3 years",
                    1 => "Not yet",
                ]
            ],

            [
                "category" => QuestionCategory::LEADER_SHIP_AND_PEPPLE_SKILLS,
                "title" => "How do you encourage team
members to take responsibilities of
the problems they encounter and
find solutions independently?",
                "answers" => [
                    3 => "I promote a culture of ownership and
ensure them to know they have the
authority to make decisions and take
responsibilities for their outcomes.",
                    2 => "I promote the culture of result orientation
and ensure that we assess them based on
their results so they have to take
responsibility",
                    1 => "I try to assign challenging tasks, provide
guidance when needed and determine
penalty for mistakes.",
                ]
            ],

            [
                "category" => QuestionCategory::LEADER_SHIP_AND_PEPPLE_SKILLS,
                "title" => "Do people rely on you for career
advice, even after they’ve left the
company?",
                "answers" => [
                    3 => "I’m nearly always like that.",
                    2 => "Some people would say that about me,
but others would not.",
                    1 => "That would almost never be me.",
                ]
            ],

            [
                "category" => QuestionCategory::LEADER_SHIP_AND_PEPPLE_SKILLS,
                "title" => "Do you have a very large
contact list, and are you good at
keeping in touch with people?",
                "answers" => [
                    3 => "I’m nearly always like that.",
                    2 => "Some people would say that about me,
but others would not.",
                    1 => "That would almost never be me.",
                ]
            ],

            [
                "category" => QuestionCategory::LEADER_SHIP_AND_PEPPLE_SKILLS,
                "title" => "You are in the charge of
assisting trainees of the traffic
control department to make
decisions related to on-the-spot
punishment for the violations of
traffic rules. While patrolling during
the night your trainee came across
a car without rear lights. The
trainee ordered the driver to stop
the car and conducted a detailed
inquiry. Driver revealed that he is
the owner of the car in question
and does two jobs; one during the
day and one during the early night
to save money for providing
quality education for his two twin
daughters and thus failed to notice
the situation. He also produced all
the documents related to his
claims. The trainee ordered him to
pay quite a big amount as a fine.
The driver started pleading
repeatedly that he did not violate
the rule knowingly and will be
careful hereafter, The trainee
requests you to suggest a
solution. You will suggest that, ",
                "answers" => [
                    3 => "This driver has a genuine reason and
appears to be needy, for this negligence
so ask him to pay a reasonable amount as
a fine and let him go as it is his first
offense.",
                    2 => "It is better to keep him in the judicial
custody for some time and allow him to go
after warning. ",
                    1 => "We should always fine the persons who
violate the rules laid by the department as
it is our duty to maintain the order. ",
                ]
            ],

            [
                "category" => QuestionCategory::SELF_MANAGMENT,
                "title" => "How would you rate yourself in
terms of managing your time?",
                "answers" => [
                    3 => "I’m always on time. In fact, I’m usually
early, as I believe this is important.",
                    2 => "I try to be on time, but something always
happens to make me late. Mostly stuff out
of control.",
                    1 => "I am always late. I don’t get the panic
about being on time. Who cares if you’re
only 10 or 15 minutes late.",
                ]
            ],

            [
                "category" => QuestionCategory::SELF_MANAGMENT,
                "title" => "How organised are you in the
morning?",
                "answers" => [
                    3 => "I always get everything sorted for the next
day the night before. I have all my clothes,
gear and food ready to just pick-up and
leave, I like the morning to run smooth.",
                    2 => "I make an effort to be organised, Probably
50% of the time I am, but stuff happens,
like the family always wanting me to do
stuff before I leave. I do what I can without
getting too stressed.",
                    1 => "I am disorganised. My bedroom is a mess.
It’s impossible to find what I need. It’s who
I am. I’ve always been this way, so I just
accept the consequences.",
                ]
            ],

            [
                "category" => QuestionCategory::SELF_MANAGMENT,
                "title" => "I have made a mistake that no
one else knows about. When the
problem becomes known it
causes more work for others.
Being self-managed means:",
                "answers" => [
                    3 => "I will make it up and tell them that I
messed up and jump in to help fix it, no
matter if others and I have to work more, I
will apologize and make up as much as I ",
                    2 => "if anyone realizes what I've done I will
admit my mistake and make it up in the
best way.",
                    1 => "Because reputation is what matters in our
company, I won’t admit that it’s my fault
but I try my best to make it up and find the
best solution for the situation.",
                ]
            ],

            [
                "category" => QuestionCategory::SELF_MANAGMENT,
                "title" => "Which one describes you the
best in described situation?
When I get upset and my mind
gets involved in my emotions:",
                "answers" => [
                    3 => "I try to find the information that I need to
understand my situation and find an outlet
to express my emotions (writing, playing
music, drawing, etc,), ",
                    2 => "I can not communicate with others and I
focus on ways that I can change the
situation to make it better.",
                    1 => "My thoughts are consumed by the
stressful situation and this make me
overthink about my problems and when
people want to help me, I reject their offer.",
                ]
            ],

            [
                "category" => QuestionCategory::SELF_MANAGMENT,
                "title" => "Imagine you are working for five
years in a company where you like
the culture and also you love your
job, but now everything that you
do is repetitive and there is
nothing new or challenging for
you, what is your approach in this
situation?",
                "answers" => [
                    3 => "I will share my issue with my manager and
try to convince them for my promotion, but
if s/he did not accept I try to change my
job.",
                    2 => "Because I love my job and company I wait
for the promotion and try to show my
abilities and qualifications during this time.",
                    1 => "Being perfect in what I do and enjoying it is
what matters to me, so I keep doing it
perfectly and powerfully.",
                ]
            ],

            [
                "category" => QuestionCategory::AI_AND_TECH,
                "title" => "Which one describes you the
best?",
                "answers" => [
                    3 => "I always update my devices as soon as a
new device comes.",
                    2 => "When I feel my devices are too old, I
change them.",
                    1 => "I won’t update or change my devices until
it’s needed.",
                ]
            ],

            [
                "category" => QuestionCategory::AI_AND_TECH,
                "title" => "How often do you use AI search
engines?",
                "answers" => [
                    3 => "Every day for every question I have, my
first solution is search in these search
engines. ",
                    2 => "I have used it several times for complex
topics",
                    1 => "I have not used them yet.",
                ]
            ],

            [
                "category" => QuestionCategory::AI_AND_TECH,
                "title" => "Which one describes you the
best?",
                "answers" => [
                    3 => "My friends and family always contact me
when they have problems with their
devices.",
                    2 => "I know how to solve some routine
problems of my devices (updating/ re
install program, check network
connection, etc)",
                    1 => "I need support to solve the problems of
my devices because I can not handle them
independently.",
                ]
            ],

            [
                "category" => QuestionCategory::AI_AND_TECH,
                "title" => "Which programming language is
commonly used for AI and
machine learning?",
                "answers" => [
                    3 => "Python",
                    2 => ".NET",
                    1 => "CSS",
                ]
            ],

            [
                "category" => QuestionCategory::AI_AND_TECH,
                "title" => "What is your familiarity with
programming languages?",
                "answers" => [
                    3 => "I am proficient in multiple programming
languages and use them for various
applications, including AI and web
development.",
                    2 => "I have some experience with at least one
programming language and can write
basic code.",
                    1 => "I have heard of programming languages
but have not used them much.",
                ]
            ],
        ];

        foreach ($questions as $question) {
            $newQuestion = Question::create(
                ['title' => $question['title'], 'category' => $question['category']]
            );

            foreach ($question['answers'] as $score => $title) {

                // dd($key, $answer);e
                Answer::create(
                    ['question_id' => $newQuestion->getKey(), 'title' => $title, 'score' => $score]
                );
            }
        }
    }
}
