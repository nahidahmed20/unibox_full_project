@extends('frontend.layouts.app')
@section('title', 'Return & Refund Policy')

@push('css')
<link rel="stylesheet" href="{{ asset('frontend/assets/css/pages/home-return-policy-1.css') }}">
@endpush

@section('content')
<main>
    <section class="container mw-930">
        <div class="row justify-content-center">
            <div class="col-lg-10 col-md-12">
                
                <div class="policy-wrapper">
                    <h1 class="policy-header-title">Return & Refund Policy</h1>
                    <span class="policy-last-updated">Last Updated: {{ date('F d, Y') }}</span>

                    <h5 class="policy-section-title text-danger">পার্সেল চেকিং পলিসি (Instant Check Policy)</h5>
                    <p class="policy-text">
                        {{ setting('company_name', 'Unibox') }}-এ আমরা স্বচ্ছতায় বিশ্বাস করি। তাই আমাদের পলিসি অনুযায়ী, পার্সেল রিসিভ করার সময় <strong>অবশ্যই ডেলিভারি ম্যানের উপস্থিতিতে পার্সেল খুলে পণ্য চেক করে নিতে হবে।</strong>
                    </p>
                    <ul class="policy-list">
                        <li>পণ্যটি আপনার অর্ডারের সাথে মিলেছে কিনা এবং ঠিক আছে কিনা, তা ডেলিভারি ম্যান সামনে থাকা অবস্থায়ই নিশ্চিত করুন।</li>
                        <li>যদি ভুল পণ্য যায়, কোনো ড্যামেজ থাকে অথবা কোনো অংশ মিসিং থাকে, তাহলে <strong>পণ্য রিসিভ না করে সাথে সাথে ডেলিভারি ম্যানের কাছে ফেরত দিন</strong> এবং আমাদের সাপোর্টে কল করে জানান।</li>
                        <li class="text-danger fw-bold">ডেলিভারি ম্যান চলে যাওয়ার পর "পণ্য ভাঙা", "ভুল পণ্য" বা "পণ্য মিসিং" এজাতীয় কোনো অভিযোগ বা রিটার্ন রিকোয়েস্ট কোনোভাবেই গ্রহণযোগ্য হবে না।</li>
                    </ul>

                    <h5 class="policy-section-title">যেসব কারণে রিটার্ন করা যাবে</h5>
                    <ul class="policy-list">
                        <li>অর্ডার করা পণ্যের পরিবর্তে সম্পূর্ণ ভিন্ন কোনো পণ্য ডেলিভারি হলে।</li>
                        <li>পণ্যটি ফিজিক্যালি ড্যামেজ বা ভাঙা অবস্থায় থাকলে (অবশ্যই ডেলিভারি ম্যানকে দেখাতে হবে)।</li>
                        <li>ওয়েবসাইটে দেখানো ছবির সাথে পণ্যের কালার বা ডিজাইনের বড় ধরনের কোনো অমিল থাকলে।</li>
                    </ul>

                    <h5 class="policy-section-title">ডেলিভারি ও রিটার্ন চার্জ (Shipping Charges)</h5>
                    <ul class="policy-list">
                        <li><strong>আমাদের ত্রুটি হলে:</strong> যদি আমরা ভুল পণ্য বা ড্যামেজ পণ্য পাঠিয়ে থাকি এবং আপনি সেটি ডেলিভারি ম্যানের কাছে সাথে সাথে ফেরত দেন, তবে এর জন্য আপনাকে কোনো ডেলিভারি বা রিটার্ন চার্জ দিতে হবে না।</li>
                        <li><strong>কাস্টমারের সিদ্ধান্ত পরিবর্তন হলে:</strong> পণ্য সম্পূর্ণ ঠিক থাকার পরও যদি আপনি নিজের পছন্দে বা অন্য কোনো কারণে পণ্যটি নিতে না চান, তবে আপনাকে অবশ্যই <strong>ডেলিভারি চার্জটি (Courier Charge)</strong> ডেলিভারি ম্যানকে প্রদান করে পণ্যটি রিটার্ন করতে হবে।</li>
                    </ul>

                    <h5 class="policy-section-title">রিফান্ড পলিসি (Refund Policy)</h5>
                    <p class="policy-text">
                        যদি কোনো কারণে অর্ডার বাতিল হয় অথবা আপনি ইনস্ট্যান্ট রিটার্ন করেন এবং পূর্বে পেমেন্ট করা থাকে, তবে রিফান্ডের নিয়মাবলি নিম্নরূপ:
                    </p>
                    <ul class="policy-list">
                        <li>পণ্যটি আমাদের ওয়্যারহাউজে ফেরত আসার পর <strong>৫ থেকে ৭ কার্যদিবসের মধ্যে</strong> আপনার রিফান্ড প্রসেস করা হবে।</li>
                        <li>রিফান্ডের টাকা আপনার বিকাশ, নগদ অথবা ব্যাংক অ্যাকাউন্টের মাধ্যমে প্রদান করা হবে।</li>
                        <li>পণ্য ঠিক থাকার পরও কাস্টমার রিটার্ন করলে, শুধু ডেলিভারি চার্জ কর্তন করে অবশিষ্ট পেমেন্ট রিফান্ড করা হবে।</li>
                    </ul>

                    <h5 class="policy-section-title">যোগাযোগ (Contact Us)</h5>
                    <p class="policy-text">
                        রিটার্ন বা রিফান্ড সংক্রান্ত যেকোনো জরুরি প্রয়োজনে ডেলিভারি ম্যান থাকা অবস্থায়ই আমাদের সাথে যোগাযোগ করুন:
                    </p>
                    <ul class="policy-list" style="list-style-type: none; padding-left: 0;">
                        <li>📞 <strong>Phone:</strong> [আপনার ফোন নাম্বার দিন]</li>
                        <li>📧 <strong>Email:</strong> [আপনার ইমেইল দিন]</li>
                        <li>💬 <strong>Facebook Page:</strong> [আপনার ফেসবুক পেজের লিংক]</li>
                    </ul>
                </div>

            </div>
        </div>
    </section>
</main>
@endsection