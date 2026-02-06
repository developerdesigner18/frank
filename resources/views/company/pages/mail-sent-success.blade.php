<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8"/>
    <title>Forgot Password | Mystery Visitor </title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @include('company.layouts.header-links')
</head>

<body>

<div class="flex min-h-dvh h-full p-4 md:p-6">
    <div class="flex justify-center items-center w-full ">
        <div class="w-full max-w-md">
            <div class="bg-white shadow-lg rounded-2xl p-4 md:p-8">
                <div class="flex flex-col items-center pb-4">
                    <img alt="CheckMyZaak logo" class=" h-10 sm:h-12 w-auto" src="{{asset('assets/logo/logo.png')}}">
                    <h1 class="text-xl sm:text-2xl font-semibold pt-3 text-gray-600">Delivered!</h1>
                    <p class=" text-xs sm:text-sm text-center text-gray-500 pt-1">A mail has been sent your mail.</p>
                </div>
                <p class="pt-6 text-center text-xs sm:text-sm text-gray-500">
                    <a class="font-semibold text-[#0073AF] hover:!underline" href="{{route('company.login')}}">
                        Back to Login
                    </a>
                </p>
            </div>
        </div>
    </div>
</div>
<!-- end auth-page-wrapper -->

@include('company.layouts.footer-links')
@include('company.layouts.common-js')

</body>
</html>
