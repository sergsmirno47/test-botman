<?php

namespace App\Http\Controllers;

use BotMan\BotMan\BotMan;
use BotMan\BotMan\Messages\Incoming\Answer;
use BotMan\BotMan\Messages\Outgoing\Actions\Button;
use BotMan\BotMan\Messages\Outgoing\Question;
use Illuminate\Http\Request;

class BotController extends Controller
{
    //https://cc2e-194-242-100-112.ngrok-free.app/bot
    public function __invoke(): void
    {
        $botman = app('botman');

        $botman->hears(['hi', 'Hi'], function($botman) {
            $this->askQuestion($botman);
        });

        $botman->hears(['what is your name', 'your name'], function($botman) {
            $botman->reply('My name is Botti');
            $this->askName($botman);
        });

        $botman->hears(['i am max'], function($botman) {
            $botman->reply('Поцілуй мене в дупу!!!!!');
            $this->askName($botman);
        });

        $botman->fallback(function($botman) {
            $botman->reply('Sorry, I did not understand these commands. Start a conversation by saying hi, please.');
        });

        $botman->listen();
    }

    public function askQuestion($botman)
    {
        $question = Question::create("You choose??");
        $question->addButtons([
            Button::create('one')->value(1),
            Button::create('two')->value(2),
            Button::create('three')->value(3),
        ]);
        $botman->ask($question, function ($answer, $conversation) {
            $this->say('value: ' . $answer);
            $this->myvalue = $answer->getText();

            $conversation->ask('Can you tell me your email?', function (Answer $answer, $conversation) {
                $this->myemail = $answer->getText();

                $this->say('Email : ' . $this->myemail);

//                $this->userStorage()->save([
//                    'email' => $email,
//                ]);

                $conversation->ask('Confirm, if the above email is correct. You can simply with yes or no!', function (Answer $answer) {
                    if ($answer == 'yes' || $answer == 'Yes') {
                        $this->say('Thanks for information. Your email: ' . $this->myemail);
                    } else {
                        $this->say('not good((');
                    }
                });
            });
        });
    }

    public function askName($botman)
    {
        $botman->ask('What is your firstname?', function(Answer $answer) {
            // Save result
            $this->firstname = $answer->getText();

            $this->say('Nice to meet you '.$this->firstname);
        });
    }

    public function askEmail($botman)
    {
        $botman->ask('Can you tell me your email?', function (Answer $answer, $conversation)
        {
            $email= $answer->getText();

            $this->say('Email : ' . $email);

            $conversation->ask('Confirm, if the above email is correct. You can simply with yes or no!', function (Answer $answer, $conversation)
            {
                $confirmEmail= $answer->getText();

                if($answer == 'yes' || $answer == 'Yes')
                {
                    $this->say('We have got your details!');
                }
                else
                {
                    $this->say('Try more.....');
                }
            });
        });
    }
}
