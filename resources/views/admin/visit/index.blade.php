@extends('admin.master')
@section('title', $page.' visits')
@push('navbar')
    <div class="pt-6 flex justify-between items-center lg:hidden capitalize">
        <span class="text-2xl font-semibold text-gray-800">{{ $page }} visits</span>
        @if($page=='all' || $page=='available')
            <div class="relative w-auto">
                <button command="show-modal" commandfor="add-visit-model"
                        class="btn-primary w-full appearance-none border border-[#e5e7eb] bg-gray-100 rounded-full px-4 py-2.5 text-gray-700 cursor-pointer transition-all duration-300">
                    <span>{{ trans_message('add_visit') }}</span>
                </button>
            </div>
        @endif
    </div>
@endpush
@push('modal')
    <!-- Add Visit Model -->
    <el-dialog>
        <dialog id="add-visit-model" aria-labelledby="dialog-title"
                class="fixed inset-0 size-auto max-h-none max-w-none overflow-y-auto bg-transparent backdrop:bg-transparent">
            <el-dialog-backdrop
                    class="fixed inset-0 bg-gray-900/50 transition-opacity data-closed:opacity-0 data-enter:duration-300 data-enter:ease-out data-leave:duration-200 data-leave:ease-in"></el-dialog-backdrop>

            <div tabindex="0"
                 class="flex min-h-full justify-center p-4 text-center focus:outline-none items-center sm:p-0">
                <el-dialog-panel
                        class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl outline -outline-offset-1 outline-white/10 transition-all data-closed:translate-y-4 data-closed:opacity-0 data-enter:duration-300 data-enter:ease-out data-leave:duration-200 data-leave:ease-in sm:my-8 w-full max-w-lg data-closed:sm:translate-y-0 data-closed:sm:scale-95">
                    <div class="bg-white relative px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="sm:flex flex-col sm:items-start">
                            <div class="flex pb-4 justify-between w-full items-center">
                                <h3 id="add-visit-dialog-title" class="text-base font-semibold text-gray-800">
                                    {{ trans_message('mystery_visit_event') }}</h3>
                                <button type="button" command="close" commandfor="add-visit-model"
                                        class="rounded-full p-2 text-gray-800 hover:bg-gray-200 transition-all duration-300 cursor-pointer absolute right-3 top-3">
                                    <svg class="size-[18px]" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                         fill="currentColor">
                                        <path d="M11.9997 10.5865L16.9495 5.63672L18.3637 7.05093L13.4139 12.0007L18.3637 16.9504L16.9495 18.3646L11.9997 13.4149L7.04996 18.3646L5.63574 16.9504L10.5855 12.0007L5.63574 7.05093L7.04996 5.63672L11.9997 10.5865Z">
                                        </path>
                                    </svg>
                                </button>
                            </div>
                            <div class="flex flex-col gap-2 w-full">
                                <form class="flex flex-col gap-5 w-full" id="addVisitForm">
                                    @csrf

                                    <!-- Branch Field -->
                                    <div class="w-full flex flex-col gap-1">
                                        <label for="branch"
                                               class="block text-sm font-medium text-gray-700">{{ trans_message('branch') }}
                                            <span class="text-[red]">*</span></label>
                                        <div class="relative">
                                            <select name="branch_id"
                                                    class="w-full appearance-none px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                                <option value="">{{ trans_message('select') }}</option>
                                                @foreach($branch_list as $bVal)
                                                    <option value="{{ $bVal->id }}">{{ $bVal->branch_name }}</option>
                                                @endforeach
                                            </select>
                                            <svg class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-500 size-5 pointer-events-none"
                                                 xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                 fill="currentColor">
                                                <path d="M11.9999 13.1714L16.9497 8.22168L18.3639 9.63589L11.9999 15.9999L5.63599 9.63589L7.0502 8.22168L11.9999 13.1714Z">
                                                </path>
                                            </svg>
                                        </div>
                                        <label id="branch_id-error" class="text-[red] error" for="branch_id"
                                               style="display: none"></label>
                                    </div>

                                    <!-- Period Range Field -->
                                    <div class="w-full flex flex-col gap-1">
                                        <label class="block text-sm font-medium text-gray-700">{{ trans_message('period_range') }}
                                            <span class="text-[red]">*</span></label>
                                        <div class="flex gap-2 justify-between items-center w-full">
                                            <div class="w-[47%]">
                                                <input type="date" id="start_datetime" name="start_datetime"
                                                       value=""
                                                       class="px-3 w-full py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 appearance-none focus:border-transparent">
                                                <label id="start_datetime-error" class="text-[red] error"
                                                       for="start_datetime" style="display: none"></label>
                                            </div>
                                            <span class="text-gray-500">-</span>
                                            <div class="w-[47%]">
                                                <input type="date" id="end_datetime" name="end_datetime"
                                                       value=""
                                                       class=" px-3 py-2 w-full border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 appearance-none focus:border-transparent">
                                                <label id="end_datetime-error" class="text-[red] error"
                                                       for="end_datetime" style="display: none"></label>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Questionnaire Field -->
                                    <div class="w-full flex flex-col gap-1">
                                        <label for="questionnaire"
                                               class="block text-sm font-medium text-gray-700">{{ trans_message('questionnaire') }}
                                            <span class="text-[red]">*</span></label>
                                        <div class="relative w-full">
                                            <select id="questionnaire_id" name="questionnaire_id"
                                                    class="w-full appearance-none px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                                <option value="">{{ trans_message('select') }}</option>
                                                @foreach($questionnaires_list as $qusVal)
                                                    <option value="{{ $qusVal->id }}">{{ $qusVal->name }}</option>
                                                @endforeach
                                            </select>
                                            <svg class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-500 size-5 pointer-events-none"
                                                 xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                 fill="currentColor">
                                                <path d="M11.9999 13.1714L16.9497 8.22168L18.3639 9.63589L11.9999 15.9999L5.63599 9.63589L7.0502 8.22168L11.9999 13.1714Z">
                                                </path>
                                            </svg>
                                        </div>
                                        <label id="questionnaire_id-error" class="text-[red] error"
                                               for="questionnaire_id" style="display: none"></label>
                                    </div>

                                    <!-- Price Field -->
                                    <div class="w-full flex flex-col gap-1">
                                        <label for="price"
                                               class="block text-sm font-medium text-gray-700">{{ trans_message('price') }}
                                            <span class="text-[red]">*</span></label>
                                        <div class="relative w-full">
                                            <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-500">€</span>
                                            <input type="number" id="price" name="price" step="0.01" placeholder="0.00"
                                                   class="w-full pl-8 pr-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                        </div>
                                        <label id="price-error" class="text-[red] error" for="price"
                                               style="display: none"></label>
                                    </div>

                                    <!-- Expense Estimate Field -->
                                    <div class="w-full flex flex-col gap-1">
                                        <label class="block text-sm font-medium text-gray-700">{{ trans_message('expense_estimate') }}
                                            <span class="text-[red]">*</span></label>
                                        <div class="flex items-center gap-2 w-full">
                                            <div>
                                                <div class="relative flex-1">
                                                    <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-500">€</span>
                                                    <input type="number" id="expense_estimation_min"
                                                           name="expense_estimation_min" step="0.01"
                                                           placeholder="0.00"
                                                           class="w-full pl-8 pr-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                                </div>
                                                <label id="expense_estimation_min-error" class="text-[red] error"
                                                       for="expense_estimation_min" style="display: none"></label>
                                            </div>
                                            <span class="text-gray-500">-</span>
                                            <div>
                                                <div class="relative flex-1">
                                                    <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-500">€</span>
                                                    <input type="number" id="expense_estimation_max"
                                                           name="expense_estimation_max" step="0.01"
                                                           placeholder="0.00"
                                                           class="w-full pl-8 pr-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                                </div>
                                                <label id="expense_estimation_max-error" class="text-[red] error"
                                                       for="expense_estimation_max" style="display: none"></label>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Description Field -->
                                    <div class="w-full flex flex-col gap-1">
                                        <label for="description"
                                               class="block text-sm font-medium text-gray-700">{{ trans_message('description') }}</label>
                                        <textarea id="description" name="description" rows="3"
                                                  placeholder="{{ trans_message('enter_description') }}"
                                                  class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent resize-none"></textarea>
                                    </div>

                                    <!-- Visitor Field -->
                                    <div class="w-full flex flex-col gap-1">
                                        <label for="visitor"
                                               class="block text-sm font-medium text-gray-700">{{ trans_message('visitor') }}</label>
                                        <div class="relative w-full">
                                            <select id="visitor_id" name="visitor_id"
                                                    class="w-full appearance-none px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                                <option value="">{{ trans_message('select') }}</option>
                                                @foreach($visitors_list as $vVal)
                                                    <option value="{{ $vVal->id }}">{{ $vVal->first_name }} {{ $vVal->last_name??'' }}</option>
                                                @endforeach
                                            </select>
                                            <svg class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-500 size-5 pointer-events-none"
                                                 xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                 fill="currentColor">
                                                <path d="M11.9999 13.1714L16.9497 8.22168L18.3639 9.63589L11.9999 15.9999L5.63599 9.63589L7.0502 8.22168L11.9999 13.1714Z">
                                                </path>
                                            </svg>
                                        </div>
                                    </div>

                                    <!-- Status Field -->
                                    <div class="w-full flex flex-col gap-1">
                                        <label for="status"
                                               class="block text-sm font-medium text-gray-700">{{ trans_message('status') }}</label>
                                        <div class="relative w-full">
                                            <select id="status" name="status"
                                                    class="w-full appearance-none px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                                @foreach(\App\Enums\VisitStatus::cases() as $status)
                                                    <option value="{{ $status->value }}">{{ $status->name }}</option>
                                                @endforeach
                                            </select>
                                            <svg class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-500 size-5 pointer-events-none"
                                                 xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                 fill="currentColor">
                                                <path d="M11.9999 13.1714L16.9497 8.22168L18.3639 9.63589L11.9999 15.9999L5.63599 9.63589L7.0502 8.22168L11.9999 13.1714Z">
                                                </path>
                                            </svg>
                                        </div>
                                    </div>

                                    <!-- Send Mail Checkbox -->
                                    <div class="w-full flex items-center gap-2 pt-2">
                                        <div class="relative flex items-center">
                                            <input type="checkbox" id="send_mail" name="send_mail" value="1" checked
                                                   class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 focus:ring-2 cursor-pointer">
                                        </div>
                                        <label for="send_mail" class="text-sm font-medium text-gray-700 cursor-pointer select-none">
                                            Send New Visit Mail
                                        </label>
                                    </div>

                                    <!-- Form Buttons -->
                                    <div class="grid grid-cols-[1fr_1fr] gap-3 pt-4 w-full">
                                        <button type="button" command="close" commandfor="add-visit-model"
                                                class="btn-secondary px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 border border-gray-300 rounded-lg hover:bg-gray-200 cursor-pointer focus:outline-none focus:ring-2 focus:ring-gray-500 transition-all duration-300">
                                            {{ trans_message('cancel') }}
                                        </button>
                                        <button type="submit"
                                                class="addVisitBtn flex justify-center btn-primary px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-blue-600 rounded-lg hover:bg-blue-700 cursor-pointer focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all duration-300">
                                            {{ trans_message('save') }}
                                        </button>
                                    </div>

                                </form>
                            </div>
                        </div>
                    </div>
                </el-dialog-panel>
            </div>
        </dialog>
    </el-dialog>

    <!-- edit Visit Model -->
    <el-dialog>
        <dialog id="edit-visit-model" aria-labelledby="dialog-title"
                class="fixed inset-0 size-auto max-h-none max-w-none overflow-y-auto bg-transparent backdrop:bg-transparent">
            <el-dialog-backdrop
                    class="fixed inset-0 bg-gray-900/50 transition-opacity data-closed:opacity-0 data-enter:duration-300 data-enter:ease-out data-leave:duration-200 data-leave:ease-in"></el-dialog-backdrop>

            <div tabindex="0"
                 class="flex min-h-full justify-center p-4 text-center focus:outline-none items-center sm:p-0">
                <el-dialog-panel
                        class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl outline -outline-offset-1 outline-white/10 transition-all data-closed:translate-y-4 data-closed:opacity-0 data-enter:duration-300 data-enter:ease-out data-leave:duration-200 data-leave:ease-in sm:my-8 w-full max-w-lg data-closed:sm:translate-y-0 data-closed:sm:scale-95">
                    <div class="bg-white relative px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="sm:flex flex-col sm:items-start">
                            <div class="flex pb-4 justify-between w-full items-center">
                                <h3 id="add-visit-dialog-title" class="text-base font-semibold text-gray-800">
                                    Mystery Visit Event</h3>
                                <button type="button" command="close" commandfor="edit-visit-model"
                                        class="rounded-full p-2 text-gray-800 hover:bg-gray-200 transition-all duration-300 cursor-pointer absolute right-3 top-3">
                                    <svg class="size-[18px]" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                         fill="currentColor">
                                        <path d="M11.9997 10.5865L16.9495 5.63672L18.3637 7.05093L13.4139 12.0007L18.3637 16.9504L16.9495 18.3646L11.9997 13.4149L7.04996 18.3646L5.63574 16.9504L10.5855 12.0007L5.63574 7.05093L7.04996 5.63672L11.9997 10.5865Z">
                                        </path>
                                    </svg>
                                </button>
                            </div>
                            <div class="flex flex-col gap-2 w-full">
                                <form class="flex flex-col gap-5 w-full" id="edit-visit-form" method="post">
                                    @csrf
                                    <input type="hidden" name="id">
                                    <!-- Branch Field -->
                                    <div class="w-full flex flex-col gap-1">
                                        <label for="branch"
                                               class="block text-sm font-medium text-gray-700">Branch <span
                                                    class="text-[red]">*</span></label>
                                        <div class="relative">
                                            <select name="branch_id"
                                                    class="w-full appearance-none px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                                <option value="">Select</option>
                                                @foreach($branch_list as $bVal)
                                                    <option value="{{ $bVal->id }}">{{ $bVal->branch_name }}</option>
                                                @endforeach
                                            </select>
                                            <svg class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-500 size-5 pointer-events-none"
                                                 xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                 fill="currentColor">
                                                <path d="M11.9999 13.1714L16.9497 8.22168L18.3639 9.63589L11.9999 15.9999L5.63599 9.63589L7.0502 8.22168L11.9999 13.1714Z">
                                                </path>
                                            </svg>
                                        </div>
                                        <label id="branch_id-error" class="text-[red] error" for="branch_id"
                                               style="display: none"></label>
                                    </div>

                                    <!-- Period Range Field -->
                                    <div class="w-full flex flex-col gap-1">
                                        <label class="block text-sm font-medium text-gray-700">Period Range (start -
                                            end) <span class="text-[red]">*</span></label>
                                        <div class="flex gap-2 justify-between items-center w-full">
                                            <div class="w-[47%]">
                                                <input type="datetime-local" id="start_datetime" name="start_datetime"
                                                       value=""
                                                       class="px-3 w-full py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 appearance-none focus:border-transparent">
                                                <label id="start_datetime-error" class="text-[red] error"
                                                       for="start_datetime" style="display: none"></label>
                                            </div>
                                            <span class="text-gray-500">-</span>
                                            <div class="w-[47%]">
                                                <input type="datetime-local" id="end_datetime" name="end_datetime"
                                                       value=""
                                                       class=" px-3 py-2 w-full border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 appearance-none focus:border-transparent">
                                                <label id="end_datetime-error" class="text-[red] error"
                                                       for="end_datetime" style="display: none"></label>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Questionnaire Field -->
                                    <div class="w-full flex flex-col gap-1">
                                        <label for="questionnaire"
                                               class="block text-sm font-medium text-gray-700">Questionnaire <span
                                                    class="text-[red]">*</span></label>
                                        <div class="relative w-full">
                                            <select id="questionnaire_id" name="questionnaire_id"
                                                    class="w-full appearance-none px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                                <option value="">Select</option>
                                                @foreach($questionnaires_list as $qusVal)
                                                    <option value="{{ $qusVal->id }}">{{ $qusVal->name }}</option>
                                                @endforeach
                                            </select>
                                            <svg class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-500 size-5 pointer-events-none"
                                                 xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                 fill="currentColor">
                                                <path d="M11.9999 13.1714L16.9497 8.22168L18.3639 9.63589L11.9999 15.9999L5.63599 9.63589L7.0502 8.22168L11.9999 13.1714Z">
                                                </path>
                                            </svg>
                                        </div>
                                        <label id="questionnaire_id-error" class="text-[red] error"
                                               for="questionnaire_id" style="display: none"></label>
                                    </div>

                                    <!-- Price Field -->
                                    <div class="w-full flex flex-col gap-1">
                                        <label for="price" class="block text-sm font-medium text-gray-700">Price <span
                                                    class="text-[red]">*</span></label>
                                        <div class="relative w-full">
                                            <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-500">€</span>
                                            <input type="number" id="price" name="price" step="0.01" placeholder="0.00"
                                                   class="w-full pl-8 pr-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                        </div>
                                        <label id="price-error" class="text-[red] error" for="price"
                                               style="display: none"></label>
                                    </div>

                                    <!-- Expense Estimate Field -->
                                    <div class="w-full flex flex-col gap-1">
                                        <label class="block text-sm font-medium text-gray-700">Expense Estimate <span
                                                    class="text-[red]">*</span></label>
                                        <div class="flex items-center gap-2 w-full">
                                            <div>
                                                <div class="relative flex-1">
                                                    <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-500">€</span>
                                                    <input type="number" id="expense_estimation_min"
                                                           name="expense_estimation_min" step="0.01"
                                                           placeholder="0.00"
                                                           class="w-full pl-8 pr-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                                </div>
                                                <label id="expense_estimation_min-error" class="text-[red] error"
                                                       for="expense_estimation_min" style="display: none"></label>
                                            </div>
                                            <span class="text-gray-500">-</span>
                                            <div>
                                                <div class="relative flex-1">
                                                    <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-500">€</span>
                                                    <input type="number" id="expense_estimation_max"
                                                           name="expense_estimation_max" step="0.01"
                                                           placeholder="0.00"
                                                           class="w-full pl-8 pr-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                                </div>
                                                <label id="expense_estimation_max-error" class="text-[red] error"
                                                       for="expense_estimation_max" style="display: none"></label>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Description Field -->
                                    <div class="w-full flex flex-col gap-1">
                                        <label for="description"
                                               class="block text-sm font-medium text-gray-700">Description</label>
                                        <textarea id="description" name="description" rows="3"
                                                  placeholder="Enter description..."
                                                  class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent resize-none"></textarea>
                                    </div>

                                    <!-- Visitor Field -->
                                    <div class="w-full flex flex-col gap-1">
                                        <label for="visitor"
                                               class="block text-sm font-medium text-gray-700">Visitor</label>
                                        <div class="relative w-full">
                                            <select id="visitor_id" name="visitor_id"
                                                    class="w-full appearance-none px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                                <option value="">Select</option>
                                                @foreach($visitors_list as $vVal)
                                                    <option value="{{ $vVal->id }}">{{ $vVal->first_name }} {{ $vVal->last_name??'' }}</option>
                                                @endforeach
                                            </select>
                                            <svg class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-500 size-5 pointer-events-none"
                                                 xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                 fill="currentColor">
                                                <path
                                                        d="M11.9999 13.1714L16.9497 8.22168L18.3639 9.63589L11.9999 15.9999L5.63599 9.63589L7.0502 8.22168L11.9999 13.1714Z">
                                                </path>
                                            </svg>
                                        </div>
                                    </div>

                                    <!-- Status Field -->
                                    <div class="w-full flex flex-col gap-1">
                                        <label for="status"
                                               class="block text-sm font-medium text-gray-700">Status</label>
                                        <div class="relative w-full">
                                            <select id="status" name="status"
                                                    class="w-full appearance-none px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                                @foreach(\App\Enums\VisitStatus::cases() as $status)
                                                    <option value="{{ $status->value }}">{{ $status->name }}</option>
                                                @endforeach
                                            </select>
                                            <svg class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-500 size-5 pointer-events-none"
                                                 xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                 fill="currentColor">
                                                <path d="M11.9999 13.1714L16.9497 8.22168L18.3639 9.63589L11.9999 15.9999L5.63599 9.63589L7.0502 8.22168L11.9999 13.1714Z">
                                                </path>
                                            </svg>
                                        </div>
                                    </div>

                                    <!-- Form Buttons -->
                                    <div class="grid grid-cols-[1fr_1fr] gap-3 pt-4 w-full">
                                        <button type="button" command="close" commandfor="edit-visit-model"
                                                class="btn-secondary px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 border border-gray-300 rounded-lg hover:bg-gray-200 cursor-pointer focus:outline-none focus:ring-2 focus:ring-gray-500 transition-all duration-300">
                                            Cancel
                                        </button>
                                        <button type="submit"
                                                class="editVisitBtn flex justify-center btn-primary px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-blue-600 rounded-lg hover:bg-blue-700 cursor-pointer focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all duration-300">
                                            Save
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </el-dialog-panel>
            </div>
        </dialog>
    </el-dialog>

    <!-- Visit Model -->
    <el-dialog>
        <dialog id="visit-model" aria-labelledby="dialog-title"
                class="fixed inset-0 size-auto max-h-none max-w-none overflow-y-auto bg-transparent backdrop:bg-transparent">
            <el-dialog-backdrop
                    class="fixed inset-0 bg-gray-900/50 transition-opacity data-closed:opacity-0 data-enter:duration-300 data-enter:ease-out data-leave:duration-200 data-leave:ease-in"></el-dialog-backdrop>

            <div tabindex="0"
                 class="flex min-h-full justify-center p-4 text-center focus:outline-none items-center sm:p-0">
                <el-dialog-panel
                        class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl outline -outline-offset-1 outline-white/10 transition-all data-closed:translate-y-4 data-closed:opacity-0 data-enter:duration-300 data-enter:ease-out data-leave:duration-200 data-leave:ease-in sm:my-8 w-full max-w-lg data-closed:sm:translate-y-0 data-closed:sm:scale-95">
                    <div class="bg-white relative px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="sm:flex flex-col sm:items-start">
                            <div class="flex pb-4 justify-between w-full items-center">
                                <h3 id="visit-dialog-title" class="text-base font-semibold text-gray-800">
                                    {{ trans_message('visit_note') }}
                                </h3>
                                <button type="button" command="close" commandfor="visit-model"
                                        class="rounded-full p-2 text-gray-800 hover:bg-gray-200 transition-all duration-300 cursor-pointer absolute right-3 top-3">
                                    <svg class="size-[18px]" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                         fill="currentColor">
                                        <path d="M11.9997 10.5865L16.9495 5.63672L18.3637 7.05093L13.4139 12.0007L18.3637 16.9504L16.9495 18.3646L11.9997 13.4149L7.04996 18.3646L5.63574 16.9504L10.5855 12.0007L5.63574 7.05093L7.04996 5.63672L11.9997 10.5865Z">
                                        </path>
                                    </svg>
                                </button>
                            </div>
                            <div class="flex flex-col gap-2">
                                <p id="visit-dialog-description"
                                   class="text-sm font-normal text-gray-800 model-data"></p>
                            </div>
                        </div>
                    </div>
                </el-dialog-panel>
            </div>
        </dialog>
    </el-dialog>
@endpush
@section('main')
    <section class="bg-white p-4 sm:p-6 rounded-2xl shadow-lg">
        <div class="flex flex-col md:flex-row items-center justify-between pb-6 gap-4">
            <div class="relative w-full md:w-auto flex-grow">
                <input type="text"
                       class="sm:pl-10 pl-8 py-2 sm:py-2.5 border border-[#e5e7eb] rounded-full w-full text-sm sm:text-base focus:outline-none focus:ring-2 focus:ring-blue-500 filter-search"
                       placeholder="{{ trans_message('search_placeholder') }}">
                <svg class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-500 size-[16px] sm:size-[20px]"
                     xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M18.031 16.6168L22.3137 20.8995L20.8995 22.3137L16.6168 18.031C15.0769 19.263 13.124 20 11 20C6.032 20 2 15.968 2 11C2 6.032 6.032 2 11 2C15.968 2 20 6.032 20 11C20 13.124 19.263 15.0769 18.031 16.6168ZM16.0247 15.8748C17.2475 14.6146 18 12.8956 18 11C18 7.1325 14.8675 4 11 4C7.1325 4 4 7.1325 4 11C4 14.8675 7.1325 18 11 18C12.8956 18 14.6146 17.2475 15.8748 16.0247L16.0247 15.8748Z">
                    </path>
                </svg>
            </div>
            <div class="flex items-center gap-4 w-full md:w-auto">
                <div class="relative w-full md:w-auto">
                    <select id="filter-sort_by"
                            class="filter-fields w-full appearance-none border border-[#e5e7eb] bg-gray-100 rounded-full px-4 py-2 sm:py-2.5 pr-8 text-sm sm:text-base text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="id_desc">{{ trans_message('most_recent') }}</option>
                        <option value="id_asc">{{ trans_message('oldest') }}</option>
                        <option value="branch_asc">{{ trans_message('branch_name_az') }}</option>
                        <option value="branch_desc">{{ trans_message('branch_name_za') }}</option>

                    </select>
                    <svg class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-500 size-[16px] sm:size-[20px] pointer-events-none"
                         xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                        <path
                                d="M11.9999 13.1714L16.9497 8.22168L18.3639 9.63589L11.9999 15.9999L5.63599 9.63589L7.0502 8.22168L11.9999 13.1714Z">
                        </path>
                    </svg>
                </div>
                @if($page=='all' || $page=='available')
                    <div class="relative w-full hidden lg:flex md:w-auto">
                        <button command="show-modal" commandfor="add-visit-model"
                                class="btn-primary w-full appearance-none border border-[#e5e7eb] bg-gray-100 rounded-full px-4 py-2.5 text-gray-700 cursor-pointer transition-all duration-300">
                            <span>{{ trans_message('add_visit') }}</span>
                        </button>
                    </div>

                @endif
            </div>
        </div>

        @if($page=='all')
            <!-- Status Filter Checkboxes -->
            <div class="flex flex-wrap items-center gap-4 py-4">
                <div class="flex items-center gap-2">
                    <input type="checkbox" id="filter-all" value="all"
                           class="filter-type w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 accent-[#0073AF] rounded"
                           checked>
                    <label for="filter-all" class="text-sm font-medium text-gray-700 cursor-pointer">All</label>
                </div>
                <div class="flex items-center gap-2">
                    <input type="checkbox" id="filter-available" value="available"
                           class="filter-type w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 accent-[#0073AF] rounded">
                    <label for="filter-available"
                           class="text-sm font-medium text-gray-700 cursor-pointer">Available</label>
                </div>
                <div class="flex items-center gap-2">
                    <input type="checkbox" id="filter-interested" value="interested"
                           class="filter-type w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 accent-[#0073AF] rounded">
                    <label for="filter-interested"
                           class="text-sm font-medium text-gray-700 cursor-pointer">Interested</label>
                </div>
                <div class="flex items-center gap-2">
                    <input type="checkbox" id="filter-scheduled" value="scheduled"
                           class="filter-type w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 accent-[#0073AF] rounded">
                    <label for="filter-scheduled"
                           class="text-sm font-medium text-gray-700 cursor-pointer">Scheduled</label>
                </div>
                <div class="flex items-center gap-2">
                    <input type="checkbox" id="filter-pending" value="pending"
                           class="filter-type w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 accent-[#0073AF] rounded">
                    <label for="filter-pending"
                           class="text-sm font-medium text-gray-700 cursor-pointer">Pending</label>
                </div>
                <div class="flex items-center gap-2">
                    <input type="checkbox" id="filter-completed" value="completed"
                           class="filter-type w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 accent-[#0073AF] rounded">
                    <label for="filter-completed"
                           class="text-sm font-medium text-gray-700 cursor-pointer">Completed</label>
                </div>
            </div>
        @endif

        <div class="flex flex-col gap-4 visitListData">

        </div>
    </section>
@endsection
@section('script')
    <script !src="">
        // $('document').ready(function (){
        //     alert('dd');
        // });

        function visitList() {
            var sort_by = $('#filter-sort_by').val();
            var search = $('.filter-search').val();
            var type = $('.filter-type:checked').map(function () {
                return $(this).val();
            }).get();
            var page = '{{ $page }}';

            let url = "{{ route("admin.visit.list",["page" => $page]) }}";
            if (page === 'completed') {
                url = "{{ route("admin.visit.completed.list",["page" => $page]) }}";
            }
            $.ajax({
                url: url,
                dataType: "JSON",
                method: "POST",
                data: {
                    "sort_by": sort_by,
                    "search": search,
                    "type": type,
                    "_token": "{{csrf_token()}}",
                },
                success: function (data) {
                    $('.visitListData').html(data.message)
                },
                error: function (xhr) {
                    let data = xhr.responseJSON;
                    if (data.hasOwnProperty('message')) {
                        actionError(xhr, data.message)
                    } else {
                        actionError(xhr);
                    }
                }
            });
        }

        visitList();

        function visitReportStatus(id, type, element) {
            var msg = "";
            if (type === 'reject') {
                msg = "This action will put back this event to In Progress status.";
            }
            Swal.fire({
                title: "Are you sure?",
                text: "Are you sure you want to " + type + " this visit? " + msg,
                icon: "warning",
                showCancelButton: !0,
                confirmButtonText: "Yes, " + type,
                cancelButtonText: "No, cancel!",
                confirmButtonClass: "btn-primary px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-blue-600 rounded-lg hover:bg-blue-700 cursor-pointer focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all duration-300",
                cancelButtonClass: "bg-gray-100 border border-gray-300 btn-secondary cursor-pointer duration-300 focus:outline-none focus:ring-2 focus:ring-gray-500 font-medium hover:bg-gray-200 ml-3 modal-cancel px-4 py-2 rounded-lg text-gray-700 text-sm transition-all",
                buttonsStyling: !1,
            }).then(function (result) {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{route('admin.visit.visitReportStatus')}}",
                        dataType: "JSON",
                        method: "POST",
                        data: {
                            "id": id,
                            "type": type,
                            "_token": "{{csrf_token()}}",
                        },
                        beforeSend: function () {
                            // $(element).attr('disabled', true);
                        },
                        success: function (data) {
                            sendToast(data.message);
                            if (type === 'reject') {
                                window.location.href = "{{ route('admin.visit.index',['page'=>'scheduled']) }}";
                            } else {
                                window.location.href = "{{ route('admin.visit.index',['page'=>'completed']) }}";
                            }
                        },
                        error: function (xhr) {
                            let data = xhr.responseJSON;
                            if (data.hasOwnProperty('message')) {
                                sendError(data.message);
                            } else {
                                sendError("An error occurred. Please try again.");
                            }
                        },
                        complete: function () {
                            $(element).attr('disabled', false);
                        }
                    });
                }
            });
        }
        $(document).delegate('.visitNote', 'click', function (e) {
            var note = $(this).data('note');
            $('#visit-model')[0].showModal();
            $('#visit-model .model-data').html(note);
        })

        $(document).delegate('.filter-type', 'change', function (e) {
            var type = $(this).val();
            if (type === 'all') {
                $('.filter-type').prop('checked', false);
                $(this).prop('checked', true);
            } else {
                $('#filter-all').prop('checked', false);
            }
            visitList();
        })

        $(document).delegate('.visitPublished', 'click', function (e) {
            var id = $(this).attr('data-id');
            var status = 0;
            if ($(this).is(":checked")) {
                status = 1;
            }
            $.ajax({
                url: "{{ route("admin.visit.published") }}",
                dataType: "JSON",
                method: "POST",
                data: {
                    "id": id,
                    "status": status,
                    "_token": "{{csrf_token()}}",
                },
                success: function (data) {
                    sendToast(data.message);
                },
                error: function (xhr) {
                    let data = xhr.responseJSON;
                    if (data.hasOwnProperty('message')) {
                        actionError(xhr, data.message)
                    } else {
                        actionError(xhr);
                    }
                }
            });
        });

        // Remove visit
        function removeVisit(id, element) {
            Swal.fire({
                title: "Are you sure?",
                text: "Are you sure you want to remove this visit?",
                icon: "warning",
                showCancelButton: !0,
                confirmButtonText: "Yes, remove",
                cancelButtonText: "No, cancel!",
                confirmButtonClass: "btn-primary px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-blue-600 rounded-lg hover:bg-blue-700 cursor-pointer focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all duration-300",
                cancelButtonClass: "bg-gray-100 border border-gray-300 btn-secondary cursor-pointer duration-300 focus:outline-none focus:ring-2 focus:ring-gray-500 font-medium hover:bg-gray-200 ml-3 modal-cancel px-4 py-2 rounded-lg text-gray-700 text-sm transition-all",
                buttonsStyling: !1,
            }).then(function (t) {
                if (t.value) {
                    $.ajax({
                        url: "{{route('admin.visit.delete')}}",
                        dataType: "JSON",
                        method: "POST",
                        data: {
                            "id": id,
                            "_token": "{{csrf_token()}}",
                        },
                        beforeSend: function () {
                            $(element).attr('disabled', true);
                        },
                        success: function (data) {
                            sendToast(data.message);
                            visitList();
                        },
                        error: function (xhr) {
                            let data = xhr.responseJSON;
                            if (data.hasOwnProperty('message')) {
                                sendError(data.message);
                            } else {
                                sendError("An error occurred. Please try again.");
                            }
                        },
                        complete: function () {
                            $(element).attr('disabled', false);
                        }
                    });
                }
            });
        }

        // Duplicate visit
        function duplicateVisit(id, element) {
            Swal.fire({
                title: "Are you sure?",
                text: "Are you sure you want to duplicate this visit?",
                icon: "warning",
                showCancelButton: !0,
                confirmButtonText: "Yes, duplicate",
                cancelButtonText: "No, cancel!",
                confirmButtonClass: "btn-primary px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-blue-600 rounded-lg hover:bg-blue-700 cursor-pointer focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all duration-300",
                cancelButtonClass: "bg-gray-100 border border-gray-300 btn-secondary cursor-pointer duration-300 focus:outline-none focus:ring-2 focus:ring-gray-500 font-medium hover:bg-gray-200 ml-3 modal-cancel px-4 py-2 rounded-lg text-gray-700 text-sm transition-all",
                buttonsStyling: !1,
            }).then(function (t) {
                if (t.value) {
                    $.ajax({
                        url: "{{route('admin.visit.duplicate')}}",
                        dataType: "JSON",
                        method: "POST",
                        data: {
                            "id": id,
                            "_token": "{{csrf_token()}}",
                        },
                        beforeSend: function () {
                            $(element).attr('disabled', true);
                        },
                        success: function (data) {
                            sendToast(data.message)
                            visitList();
                        },
                        error: function (xhr) {
                            let data = xhr.responseJSON;
                            if (data.hasOwnProperty('message')) {
                                sendError(data.message);
                            } else {
                                sendError("An error occurred. Please try again.");
                            }
                        },
                        complete: function () {
                            $(element).attr('disabled', false);
                        }
                    });
                }
            });
        }

        $('.filter-fields').on('change', function (e) {
            visitList();
        });
        $('.filter-search').on('keyup', function (e) {
            visitList();
        });

        function getVisit(id, element) {
            $.ajax({
                url: "{{route('admin.visit.edit')}}",
                dataType: "JSON",
                method: "POST",
                data: {
                    "id": id,
                    "_token": "{{csrf_token()}}",
                },
                success: function (data) {
                    console.log(data.data.start_datetime);
                    var start_datetime = new Date(data.data.start_datetime);
                    start_datetime = start_datetime.toISOString().slice(0, 16);
                    var end_datetime = new Date(data.data.end_datetime);
                    end_datetime = end_datetime.toISOString().slice(0, 16);

                    $("#edit-visit-form input[name=id]").val(id);
                    $('#edit-visit-form select[name=branch_id]').val(data.data.branch_id);
                    $('#edit-visit-form input[name=start_datetime]').val(start_datetime);
                    $('#edit-visit-form input[name=end_datetime]').val(end_datetime);
                    $('#edit-visit-form select[name=questionnaire_id]').val(data.data.questionnaire_id);
                    $('#edit-visit-form input[name=price]').val(data.data.price);
                    $('#edit-visit-form input[name=expense_estimation_min]').val(data.data.expense_estimation_min);
                    $('#edit-visit-form input[name=expense_estimation_max]').val(data.data.expense_estimation_max);
                    $('#edit-visit-form textarea[name=description]').html(data.data.description);
                    $('#edit-visit-form select[name=visitor_id]').val(data.data.visitor_id);
                    $('#edit-visit-form select[name=status]').val(data.data.status);

                    $('#edit-visit-model')[0].showModal();
                },
                error: function (xhr) {
                    let data = xhr.responseJSON;
                    if (data.hasOwnProperty('error')) {
                        if (data.error.hasOwnProperty('id')) {
                            sendError(data.error.id);
                        }
                    } else if (data.hasOwnProperty('message')) {
                        actionError(xhr, data.message)
                    } else {
                        actionError(xhr);
                    }
                }
            });
        }

        $("#addVisitForm").validate({
            rules: {
                branch_id: {required: true},
                questionnaire_id: {required: true},
                start_datetime: {required: true},
                end_datetime: {required: true},
                price: {
                    required: true,
                    number: true,
                    min: 0
                },
                expense_estimation_min: {
                    required: true,
                    number: true,
                    min: 0
                },
                expense_estimation_max: {
                    required: true,
                    number: true,
                    min: function () {
                        return parseFloat($('#expenseMin').val()) || 0;
                    }
                },
                // visitor_id: {required: true},
                status: {required: true}
            },
            messages: {
                branch_id: {required: "{{ trans_message('select_branch') }}"},
                questionnaire_id: {required: "{{ trans_message('select_questionnaire') }}"},
                start_datetime: {required: "{{ trans_message('select_visit_start') }}"},
                end_datetime: {required: "{{ trans_message('select_visit_end') }}"},
                price: {
                    required: "{{ trans_message('enter_price') }}",
                    number: "{{ trans_message('number_valid') }}",
                    min: "{{ trans_message('price_negative') }}"
                },
                expense_estimation_min: {
                    required: "{{ trans_message('enter_min_expense') }}",
                    number: "{{ trans_message('number_valid') }}",
                    min: "{{ trans_message('expense_negative') }}"
                },
                expense_estimation_max: {
                    required: "{{ trans_message('enter_max_expense') }}",
                    number: "{{ trans_message('number_valid') }}",
                    min: "{{ trans_message('max_expense_greater') }}"
                },
                // visitor_id: {required: "{{ trans_message('select_visitor') }}"},
                status: {required: "{{ trans_message('select_status') }}"}
            },
            errorPlacement: function (error, element) {
                error.insertAfter(element);
            },
            submitHandler: function (form, e) {
                e.preventDefault();

                $.ajax({
                    url: "{{ route('admin.visit.save') }}",
                    method: "POST",
                    dataType: "json",
                    data: new FormData(form),
                    processData: false,
                    contentType: false,
                    cache: false,
                    beforeSend: function () {
                        $('.addVisitBtn').attr('disabled', true).html(`
                            <svg class="animate-spin h-4 w-4 text-white mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            Processing...
                        `);
                    },
                    success: function (result) {
                        $('#add-visit-model')[0].close();
                        sendToast(result.message)
                        visitList();
                    },
                    error: function (xhr) {
                        let data = xhr.responseJSON;
                        if (data.hasOwnProperty('errors')) {
                            $.each(data.errors, function (key, value) {
                                $("#" + key + "-error").html(value[0]).show();
                            });
                        } else if (data.hasOwnProperty('message')) {
                            sendError(data.message);
                        } else {
                            sendError("An error occurred. Please try again.");
                        }
                    },
                    complete: function () {
                        $('.addVisitBtn').attr('disabled', false).html('save');
                    }
                });
            }
        });

        $("#edit-visit-form").validate({
            rules: {
                branch_id: {required: true},
                questionnaire_id: {required: true},
                start_datetime: {required: true},
                end_datetime: {required: true},
                price: {
                    required: true,
                    number: true,
                    min: 0
                },
                expense_estimation_min: {
                    required: true,
                    number: true,
                    min: 0
                },
                expense_estimation_max: {
                    required: true,
                    number: true,
                    min: function () {
                        return parseFloat($('#editExpenseMin').val()) || 0;
                    }
                },
                // visitor_id: {required: true},
                status: {required: true}
            },
            messages: {
                branch_id: {required: "{{ trans_message('select_branch') }}"},
                questionnaire_id: {required: "{{ trans_message('select_questionnaire') }}"},
                start_datetime: {required: "{{ trans_message('select_visit_start') }}"},
                end_datetime: {required: "{{ trans_message('select_visit_end') }}"},
                price: {
                    required: "{{ trans_message('enter_price') }}",
                    number: "{{ trans_message('number_valid') }}",
                    min: "{{ trans_message('price_negative') }}"
                },
                expense_estimation_min: {
                    required: "{{ trans_message('enter_min_expense') }}",
                    number: "{{ trans_message('number_valid') }}",
                    min: "{{ trans_message('expense_negative') }}"
                },
                expense_estimation_max: {
                    required: "{{ trans_message('enter_max_expense') }}",
                    number: "{{ trans_message('number_valid') }}",
                    min: "{{ trans_message('max_expense_greater') }}"
                },
                // visitor_id: {required: "{{ trans_message('select_visitor') }}"},
                status: {required: "{{ trans_message('select_status') }}"}
            },
            errorPlacement: function (error, element) {
                error.insertAfter(element);
            },
            submitHandler: function (form, e) {
                e.preventDefault();
                let id = $('#edit_visit_id').val();

                $.ajax({
                    url: "{{ route('admin.visit.update') }}",
                    method: "POST",
                    dataType: "json",
                    data: new FormData(form),
                    processData: false,
                    contentType: false,
                    cache: false,
                    beforeSend: function () {
                        $('.editVisitBtn').attr('disabled', true).html(`
                            <svg class="animate-spin h-4 w-4 text-white mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            Processing...
                        `);
                    },
                    success: function (result) {
                        $('#edit-visit-model')[0].close();
                        sendToast(result.message)
                        visitList();
                    },
                    error: function (xhr) {
                        let data = xhr.responseJSON;
                        if (data.hasOwnProperty('errors')) {
                            $.each(data.errors, function (key, value) {
                                $("#edit_" + key + "-error").html(value[0]).show();
                            });
                        } else if (data.hasOwnProperty('message')) {
                            sendError(data.message);
                        } else {
                            sendError("An error occurred. Please try again.");
                        }
                    },
                    complete: function () {
                        $('.editVisitBtn').attr('disabled', false).html('save');
                    }
                });
            }
        });


        // Request visit
        function visitReportStatus(id, type, element) {
            var scheduled_count = parseInt($('.scheduled_count').html());
            var pending_count = parseInt($('.pending_count').html());
            var completed_count = parseInt($('.completed_count').html());
            var msg = "";
            if (type === 'reject') {
                msg = "This action will put back this event to In Progress status.";
            }
            Swal.fire({
                title: "Are you sure?",
                text: "Are you sure you want to " + type + " this visit? " + msg,
                icon: "warning",
                showCancelButton: !0,
                confirmButtonText: "Yes, " + type,
                cancelButtonText: "No, cancel!",
                confirmButtonClass: "btn-primary px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-blue-600 rounded-lg hover:bg-blue-700 cursor-pointer focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all duration-300",
                cancelButtonClass: "bg-gray-100 border border-gray-300 btn-secondary cursor-pointer duration-300 focus:outline-none focus:ring-2 focus:ring-gray-500 font-medium hover:bg-gray-200 ml-3 modal-cancel px-4 py-2 rounded-lg text-gray-700 text-sm transition-all",
                buttonsStyling: !1,
            }).then(function (result) {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{route('admin.visit.visitReportStatus')}}",
                        dataType: "JSON",
                        method: "POST",
                        data: {
                            "id": id,
                            "type": type,
                            "_token": "{{csrf_token()}}",
                        },
                        beforeSend: function () {
                            // $(element).attr('disabled', true);
                        },
                        success: function (data) {
                            sendToast(data.message);
                            pending_count = pending_count - 1;
                            if (type === 'reject') {
                                scheduled_count = scheduled_count + 1;
                            } else {
                                completed_count = completed_count + 1;
                            }
                            $('.scheduled_count').html(scheduled_count);
                            $('.pending_count').html(pending_count);
                            $('.completed_count').html(completed_count);
                            visitList();
                        },
                        error: function (xhr) {
                            let data = xhr.responseJSON;
                            if (data.hasOwnProperty('message')) {
                                sendError(data.message);
                            } else {
                                sendError("An error occurred. Please try again.");
                            }
                        },
                        complete: function () {
                            $(element).attr('disabled', false);
                        }
                    });
                }
            });
        }


        // Assign visit with selected visitor
        function assignedVisit(id, element) {
            var interested_count = parseInt($('.interested_count').html());
            var scheduled_count = parseInt($('.scheduled_count').html());

            // Get the selected visitor from the dropdown
            var selectedVisitorId = $('#visitor-select-' + id).val();

            if (!selectedVisitorId) {
                sendError('Please select a visitor before assigning');
                return;
            }

            Swal.fire({
                title: "Are you sure?",
                text: "Are you sure you want to Assigned this visit? Other interested visitors will be automatically rejected.",
                icon: "warning",
                showCancelButton: !0,
                confirmButtonText: "Yes, Assigned",
                cancelButtonText: "No, cancel!",
                confirmButtonClass: "btn-primary px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-blue-600 rounded-lg hover:bg-blue-700 cursor-pointer focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all duration-300",
                cancelButtonClass: "bg-gray-100 border border-gray-300 btn-secondary cursor-pointer duration-300 focus:outline-none focus:ring-2 focus:ring-gray-500 font-medium hover:bg-gray-200 ml-3 modal-cancel px-4 py-2 rounded-lg text-gray-700 text-sm transition-all",
                buttonsStyling: !1,
            }).then(function (t) {
                if (t.value) {
                    $.ajax({
                        url: "{{route('admin.visit.assign.visitor')}}",
                        dataType: "JSON",
                        method: "POST",
                        data: {
                            "visit_id": id,
                            "visitor_id": selectedVisitorId,
                            "_token": "{{csrf_token()}}",
                        },
                        beforeSend: function () {
                            $(element).attr('disabled', true);
                        },
                        success: function (data) {
                            sendSuccess(data.message);

                            interested_count = interested_count - 1;
                            scheduled_count = scheduled_count + 1;
                            $('.interested_count').html(interested_count);
                            $('.scheduled_count').html(scheduled_count);
                            visitList();
                        },
                        error: function (xhr) {
                            let data = xhr.responseJSON;
                            if (data.hasOwnProperty('message')) {
                                sendError(data.message);
                            } else {
                                sendError("An error occurred. Please try again.");
                            }
                        },
                        complete: function () {
                            $(element).attr('disabled', false);
                        }
                    });
                }
            });
        }

        // Reject visit
        function rejectVisit(id, element) {
            var interested_count = parseInt($('.interested_count').html());
            var available_count = parseInt($('.available_count').html());
            Swal.fire({
                title: "Are you sure?",
                text: "Are you sure you want to Reject this visit?",
                icon: "warning",
                showCancelButton: !0,
                confirmButtonText: "Yes, Rejected",
                cancelButtonText: "No, cancel!",
                confirmButtonClass: "btn-primary px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-blue-600 rounded-lg hover:bg-blue-700 cursor-pointer focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all duration-300",
                cancelButtonClass: "bg-gray-100 border border-gray-300 btn-secondary cursor-pointer duration-300 focus:outline-none focus:ring-2 focus:ring-gray-500 font-medium hover:bg-gray-200 ml-3 modal-cancel px-4 py-2 rounded-lg text-gray-700 text-sm transition-all",
                buttonsStyling: !1,
            }).then(function (t) {
                if (t.value) {
                    $.ajax({
                        url: "{{route('admin.visit.reject')}}",
                        dataType: "JSON",
                        method: "POST",
                        data: {
                            "id": id,
                            status: 'OPEN',
                            "_token": "{{csrf_token()}}",
                        },
                        beforeSend: function () {
                            $(element).attr('disabled', true);
                        },
                        success: function (data) {
                            sendSuccess(data.message);
                            interested_count = interested_count - 1;
                            available_count = available_count + 1;
                            $('.interested_count').html(interested_count);
                            $('.available_count').html(available_count);
                        },
                        error: function (xhr) {
                            let data = xhr.responseJSON;
                            if (data.hasOwnProperty('message')) {
                                sendError(data.message);
                            } else {
                                sendError("An error occurred. Please try again.");
                            }
                        },
                        complete: function () {
                            $(element).attr('disabled', false);
                        }
                    });
                }
            });
        }

    </script>
@endsection
