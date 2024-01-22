<?php

it('can run diagnostic report', function () {
    $this->artisan('reporting')
        ->expectsQuestion('Student ID', 'student1')
        ->expectsQuestion('Report to generate (1 for Diagnostic, 2 for Progress, 3 for Feedback)', '1')
        ->expectsOutputToContain('Tony Stark recently completed Numeracy assessment on 16th December 2021 10:46 AM')
        ->expectsOutputToContain('He got 15 questions right out of 16. Details by strand given below:')
        ->expectsOutputToContain('Number and Algebra: 5 out of 5 correct')
        ->expectsOutputToContain('Statistics and Probability: 3 out of 4 correct')
        ->assertExitCode(0);
});

it('can run progress report', function () {
    $this->artisan('reporting')
        ->expectsQuestion('Student ID', 'student1')
        ->expectsQuestion('Report to generate (1 for Diagnostic, 2 for Progress, 3 for Feedback)', '2')
        ->expectsOutputToContain('Tony Stark has completed Numeracy assessment 3 times in total. Date and raw score given below:')
        ->expectsOutputToContain('Date: 14th December 2019, Raw Score: 6 out of 16')
        ->expectsOutputToContain('Date: 14th December 2020, Raw Score: 10 out of 16')
        ->expectsOutputToContain('Date: 14th December 2021, Raw Score: 15 out of 16')
        ->expectsOutputToContain('Tony Stark got 9 more correct in the recent completed assessment than the oldest')
        ->assertExitCode(0);
});

it('can run feedback report', function () {
    $this->artisan('reporting')
        ->expectsQuestion('Student ID', 'student1')
        ->expectsQuestion('Report to generate (1 for Diagnostic, 2 for Progress, 3 for Feedback)', '3')
        ->expectsOutputToContain('Tony Stark recently completed Numeracy assessment on 16th December 2021 10:46 AM')
        ->expectsOutputToContain('He got 15 questions right out of 16. Feedback for wrong answers given below')
        ->expectsOutputToContain("Question: What is the 'median' of the following group of numbers 5, 21, 7, 18, 9?")
        ->expectsOutputToContain('Your answer: A with value 7')
        ->expectsOutputToContain('Right answer: B with value 9')
        ->expectsOutputToContain('Hint: You must first arrange the numbers in ascending order. The median is the middle term, which in this case is 9')
        ->assertExitCode(0);
});

