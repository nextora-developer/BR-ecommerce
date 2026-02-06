<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class PageController extends Controller
{

    public function guideline()
    {
        return view('pages.guideline');
    }

    public function faq()
    {
        return view('pages.faq');
    }

    public function rewardPoint()
    {
        return view('pages.reward-point');
    }

    public function privacy()
    {
        return view('pages.privacy');
    }

    public function shipping()
    {
        return view('pages.shipping');
    }

    public function returns()
    {
        return view('pages.returns');
    }

    public function terms()
    {
        return view('pages.terms');
    }



    public function accaCourses()
    {
        $whatsapp = [
            'phone' => '60123011610', // ✅ 换你的号码
            'text'  => 'Hi! I want to get ACCA course details (Edufluence x BR Innovate Future).',
        ];

        $courses = [
            [
                'title' => 'ACCA Knowledge',
                'tag'   => 'Applied Knowledge Level',
                'price' => 'RM 3,000',
                'papers' => '3 papers only',
                'icon'  => 'brain',
                'items' => [
                    'BT — Business & Technology',
                    'FA — Financial Accounting',
                    'MA — Management Accounting',
                ],
                'badges' => [
                    ['ok' => true, 'text' => '0% instalment plan available'],
                    ['ok' => true, 'text' => 'HRDF claimable', 'sub' => 'T&C apply'],
                ],
                'notes' => [
                    'Complete within 6 months',
                    'LIVE classes or VIDEO learning',
                ],
                'desc'  => 'Start your ACCA journey with confidence. Ideal for LCCI Level 3 or above.',
            ],
            [
                'title' => 'ACCA FIA',
                'tag'   => 'Foundations in Accountancy',
                'price' => 'RM 5,800',
                'papers' => '7 papers only',
                'icon'  => 'briefcase',
                'items' => [
                    'FA1 — Recording Financial Transactions',
                    'MA1 — Management Information',
                    'FA2 — Maintaining Financial Records',
                    'MA2 — Managing Costs & Finance',
                    '+ 3 Knowledge papers',
                ],
                'badges' => [
                    ['ok' => true, 'text' => '0% instalment plan available'],
                    ['ok' => true, 'text' => 'HRDF claimable', 'sub' => 'T&C apply'],
                ],
                'notes' => [
                    'Achieve ACCA Diploma within 1 year',
                    'LIVE or VIDEO course options',
                ],
                'desc'  => 'Perfect for beginners with little or no accounting background.',
            ],
            [
                'title' => 'ACCA Skills',
                'tag'   => 'Applied Skills Level',
                'price' => 'RM 6,900',
                'papers' => '6 papers only',
                'icon'  => 'chart',
                'items' => [
                    'LW — Corporate & Business Law (MYS)',
                    'PM — Performance Management',
                    'TX — Taxation',
                    'FR — Financial Reporting',
                    'AA — Audit & Assurance (INTL)',
                    'FM — Financial Management',
                ],
                'badges' => [
                    ['ok' => true, 'text' => '0% instalment plan available'],
                    ['ok' => true, 'text' => 'HRDF claimable', 'sub' => 'T&C apply'],
                ],
                'notes' => [
                    'Earn ACCA Degree in ~1.5 years',
                    'LIVE or VIDEO classes',
                ],
                'desc'  => 'Advance your career with core professional accounting skills.',
            ],
            [
                'title' => 'ACCA Strategy',
                'tag'   => 'Strategic Professional Level',
                'price' => 'RM 5,000',
                'papers' => '4 papers only',
                'icon'  => 'target',
                'items' => [
                    'SBL — Strategic Business Leader',
                    'SBR — Strategic Business Reporting',
                    'AFM — Advanced Financial Management',
                    'AAA — Advanced Audit & Assurance',
                ],
                'badges' => [
                    ['ok' => true, 'text' => '0% instalment plan available'],
                    ['ok' => true, 'text' => 'HRDF claimable', 'sub' => 'T&C apply'],
                ],
                'notes' => [
                    'Flexible LIVE or VIDEO options',
                ],
                'desc'  => 'Transform into a strategic finance leader with global recognition.',
            ],
        ];

        return view('pages.courses.acca', compact('whatsapp', 'courses'));
    }
}
