@extends('admin.master')
@section('title',$company->company_name.' Branches')
@push('navbar')
    <div class="flex items-center gap-1 pt-4">
        <a href="{{ route('admin.company.index') }}"
           class="text-sm text-gray-800 font-medium hover:text-[#0073AF] transition-all duration-300">
            <span>Companies</span>
        </a>
        <span class="text-sm font-medium text-gray-500">/</span>
        <span class="text-sm font-medium text-gray-500 short_desc_1">{{ $company->company_name }}</span>
    </div>
    <div class="pt-6 flex justify-between items-center lg:hidden">
        <span class="text-2xl font-semibold text-gray-800 short_desc_1">{{ $company->company_name }} Branches</span>
        <div class="relative w-auto">
            <button command="show-modal" commandfor="add-branch-model"
                    class="btn-primary w-full appearance-none border border-[#e5e7eb] bg-gray-100 rounded-full px-4 py-2.5 text-gray-700 cursor-pointer transition-all duration-300">
                <span>Add Branch</span>
            </button>
        </div>
    </div>
@endpush
@push('modal')

    <!-- Add Company Model -->
    <el-dialog>
        <dialog id="add-branch-model" aria-labelledby="dialog-title"
                class="fixed inset-0 size-auto max-h-none max-w-none overflow-y-auto bg-transparent backdrop:bg-transparent">
            <el-dialog-backdrop
                    class="fixed inset-0 bg-gray-900/50 transition-opacity data-closed:opacity-0 data-enter:duration-300 data-enter:ease-out data-leave:duration-200 data-leave:ease-in"></el-dialog-backdrop>

            <div tabindex="0"
                 class="flex min-h-full justify-center p-4 text-center focus:outline-none items-center sm:p-0">
                <el-dialog-panel
                        class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl outline -outline-offset-1 outline-white/10 transition-all data-closed:translate-y-4 data-closed:opacity-0 data-enter:duration-300 data-enter:ease-out data-leave:duration-200 data-leave:ease-in sm:my-8 w-full max-w-2xl data-closed:sm:translate-y-0 data-closed:sm:scale-95">
                    <div class="bg-white relative px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="sm:flex flex-col sm:items-start">
                            <div class="flex pb-4 justify-between w-full items-center">
                                <h3 id="add-branch-dialog-title" class="text-base font-semibold text-gray-800">
                                    Company Branch Profile</h3>
                                <button type="button" command="close" commandfor="add-branch-model"
                                        class="rounded-full p-2 text-gray-800 hover:bg-gray-200 transition-all duration-300 cursor-pointer absolute right-3 top-3">
                                    <svg class="size-[18px]" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                         fill="currentColor">
                                        <path d="M11.9997 10.5865L16.9495 5.63672L18.3637 7.05093L13.4139 12.0007L18.3637 16.9504L16.9495 18.3646L11.9997 13.4149L7.04996 18.3646L5.63574 16.9504L10.5855 12.0007L5.63574 7.05093L7.04996 5.63672L11.9997 10.5865Z">
                                        </path>
                                    </svg>
                                </button>
                            </div>
                            <form class="w-full" id="addBranchForm">
                                @csrf
                                <!-- Profile Picture Section -->
                                <div class="flex flex-col items-center">
                                    <div class="relative">
                                        <!-- Profile Image Preview Box -->
                                        <div id="preview-container"
                                             class="w-24 h-24 bg-gray-200 rounded-full flex items-center justify-center mb-2 overflow-hidden">
                                            <svg id="default-icon" class="w-12 h-12 text-gray-400"
                                                 xmlns="http://www.w3.org/2000/svg"
                                                 viewBox="0 0 24 24" fill="currentColor">
                                                <path d="M12 12C14.7614 12 17 9.76142 17 7C17 4.23858 14.7614 2 12 2C9.23858 2 7 4.23858 7 7C7 9.76142 9.23858 12 12 12Z"/>
                                                <path d="M12 14C7.58172 14 4 17.5817 4 22H20C20 17.5817 16.4183 14 12 14Z"/>
                                            </svg>
                                            <img id="preview-image" src="" alt="Preview"
                                                 class="hidden w-full h-full object-cover"/>
                                        </div>

                                        <!-- File Input (hidden) -->
                                        <input type="file" id="file-input" accept="image/*" class="hidden"
                                               name="image"/>

                                        <!-- Upload Button -->
                                        <label for="file-input"
                                               class="absolute -bottom-0 -right-0 w-8 h-8 bg-[#0073AF] rounded-full flex items-center justify-center hover:bg-[#0068A0] transition-colors text-white cursor-pointer">
                                            <svg class="size-[18px]" xmlns="http://www.w3.org/2000/svg"
                                                 viewBox="0 0 24 24" fill="currentColor">
                                                <path d="M9 3H15L17 5H21C21.5523 5 22 5.44772 22 6V20C22 20.5523 21.5523 21 21 21H3C2.44772 21 2 20.5523 2 20V6C2 5.44772 2.44772 5 3 5H7L9 3ZM12 19C15.3137 19 18 16.3137 18 13C18 9.68629 15.3137 7 12 7C8.68629 7 6 9.68629 6 13C6 16.3137 8.68629 19 12 19ZM12 17C9.79086 17 8 15.2091 8 13C8 10.7909 9.79086 9 12 9C14.2091 9 16 10.7909 16 13C16 15.2091 14.2091 17 12 17Z"></path>
                                            </svg>
                                        </label>
                                    </div>
                                </div>
                                <!-- Company Name -->
                                <div class="flex flex-col gap-1 pb-4">
                                    <label class="block text-sm font-medium text-gray-700">Name</label>
                                    <input type="text" value="" name="branch_name"
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                           placeholder="Name">
                                    <label id="branch_name-error" class="text-[red] error" for="branch_name"
                                           style="display: none"></label>
                                </div>

                                <!-- Subdealer Selection -->
                                <div class="flex flex-col gap-1 pb-4">
                                    <label class="block text-sm font-medium text-gray-700">
                                        {{ trans_message('subdealer') }}
                                    </label>

                                    <div class="relative">
                                        <select
                                            name="subdealer_id"
                                            class="w-full px-4 py-3 border border-gray-300 rounded-lg bg-white
                    focus:outline-none focus:ring-2 focus:ring-blue-500
                    focus:border-transparent appearance-none"
                                        >
                                            <option value="">{{ trans_message('default_mysteryvisits') }}</option>
                                            @foreach($subdealers as $subdealer)
                                                <option value="{{ $subdealer->id }}">
                                                    {{ $subdealer->name }}
                                                </option>
                                            @endforeach
                                        </select>

                                        <!-- Dropdown Arrow -->
                                        <div class="pointer-events-none absolute inset-y-0 right-3 flex items-center text-gray-500">
                                            <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none"
                                                 viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                      stroke-width="2" d="M19 9l-7 7-7-7" />
                                            </svg>
                                        </div>
                                    </div>
                                </div>

                                <!-- Company Address -->
                                <div class="grid sm:grid-cols-2 gap-4 pb-4">
                                    <div class="flex flex-col gap-1 col-span-2">
                                        <label class="block text-sm font-medium text-gray-700">Address Line 1</label>
                                        <input type="text"
                                               value=""
                                               name="address_1"
                                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                               placeholder="Address Line 1">
                                        <label id="address_1-error" class="text-[red] error" for="address_1"
                                               style="display: none"></label>
                                    </div>
                                    <div class="flex flex-col gap-1">
                                        <label class="block text-sm font-medium text-gray-700">Locality</label>
                                        <input type="text" value="" name="locality"
                                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                               placeholder="Locality">
                                        <label id="locality-error" class="text-[red] error" for="locality"
                                               style="display: none"></label>
                                    </div>
                                    <div class="flex flex-col gap-1">
                                        <label class="block text-sm font-medium text-gray-700">Postal Code</label>
                                        <input type="text" value="" name="postal_code"
                                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                               placeholder="Postal Code">
                                        <label id="postal_code-error" class="text-[red] error" for="postal_code"
                                               style="display: none"></label>
                                    </div>
                                </div>

                                <!-- Upselling -->
                                <div class="grid sm:grid-cols-2 gap-4 pb-4">
                                    <div class="flex flex-col gap-1">
                                        <label class="block text-sm font-medium text-gray-700">Upselling Input</label>
                                        <input type="text" value="" name="upselling_input_url"
                                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                               placeholder="Upselling Input">
                                        <label id="upselling_input_url-error" class="text-[red] error"
                                               for="upselling_input_url" style="display: none"></label>
                                    </div>
                                    <div class="flex flex-col gap-1">
                                        <label class="block text-sm font-medium text-gray-700">Upselling Report</label>
                                        <input type="text" value="" name="upselling_report_url"
                                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                               placeholder="Upselling Report">
                                        <label id="upselling_report_url-error" class="text-[red] error"
                                               for="upselling_report_url" style="display: none"></label>
                                    </div>
                                </div>

                                <!-- 46% -->
                                <div class="grid sm:grid-cols-3 gap-4 pb-4">
                                    <div class="flex flex-col gap-1">
                                        <label class="block text-sm font-medium text-gray-700">46% Input</label>
                                        <input type="text" value="" name="input_url_46"
                                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                               placeholder="46% Input">
                                        <label id="input_url_46-error" class="text-[red] error" for="input_url_46"
                                               style="display: none"></label>
                                    </div>
                                    <div class="flex flex-col gap-1">
                                        <label class="block text-sm font-medium text-gray-700">46% Report</label>
                                        <input type="text" value="" name="report_url_46"
                                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                               placeholder="46% Report">
                                        <label id="report_url_46-error" class="text-[red] error" for="report_url_46"
                                               style="display: none"></label>
                                    </div>
                                    <div class="flex flex-col gap-1">
                                        <label class="block text-sm font-medium text-gray-700">Route</label>
                                        <div class="relative">
                                            <select name="route"
                                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent appearance-none">
                                                <option>{{ \App\Enums\BranchRoutes::STANDARD->value }}</option>
                                                <option>{{ \App\Enums\BranchRoutes::LIPTON->value }}</option>
                                                <option>{{ \App\Enums\BranchRoutes::VRUMONA->value }}</option>
                                                <option>{{ \App\Enums\BranchRoutes::HEINEKEN->value }}</option>
                                            </select>
                                            <svg class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-500 size-[16px] sm:size-[20px] pointer-events-none"
                                                 xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                 fill="currentColor">
                                                <path d="M11.9999 13.1714L16.9497 8.22168L18.3639 9.63589L11.9999 15.9999L5.63599 9.63589L7.0502 8.22168L11.9999 13.1714Z">
                                                </path>
                                            </svg>
                                        </div>
                                        <label id="route-error" class="text-[red] error" for="route"
                                               style="display: none"></label>
                                    </div>
                                </div>
                                <!-- Action Buttons -->
                                <div class="grid grid-cols-[1fr_1fr] gap-3 pt-4 w-full">
                                    <button type="button" command="close" commandfor="add-branch-model"
                                            class="btn-secondary modal-cancel px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 border border-gray-300 rounded-lg hover:bg-gray-200 cursor-pointer focus:outline-none focus:ring-2 focus:ring-gray-500 transition-all duration-300">
                                        Cancel
                                    </button>
                                    <button type="submit"
                                            class="btn-primary px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-blue-600 rounded-lg hover:bg-blue-700 cursor-pointer focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all duration-300 flex justify-center"
                                            id="addBranchBtn">
                                        Save
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </el-dialog-panel>
            </div>
        </dialog>
    </el-dialog>

    <!-- Edit Company Model -->
    <el-dialog>
        <dialog id="edit-branch-model" aria-labelledby="dialog-title"
                class="fixed inset-0 size-auto max-h-none max-w-none overflow-y-auto bg-transparent backdrop:bg-transparent">
            <el-dialog-backdrop
                    class="fixed inset-0 bg-gray-900/50 transition-opacity data-closed:opacity-0 data-enter:duration-300 data-enter:ease-out data-leave:duration-200 data-leave:ease-in"></el-dialog-backdrop>

            <div tabindex="0"
                 class="flex min-h-full justify-center p-4 text-center focus:outline-none items-center sm:p-0">
                <el-dialog-panel
                        class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl outline -outline-offset-1 outline-white/10 transition-all data-closed:translate-y-4 data-closed:opacity-0 data-enter:duration-300 data-enter:ease-out data-leave:duration-200 data-leave:ease-in sm:my-8 w-full max-w-2xl data-closed:sm:translate-y-0 data-closed:sm:scale-95">
                    <div class="bg-white relative px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="sm:flex flex-col sm:items-start">
                            <div class="flex pb-1 justify-between w-full items-center">
                                <h3 id="edit-branch-dialog-title" class="text-base font-semibold text-gray-800">
                                    Edit Company Branch Profile
                                </h3>
                                <button type="button" command="close" commandfor="edit-branch-model"
                                        class="rounded-full p-2 text-gray-800 hover:bg-gray-200 transition-all duration-300 cursor-pointer absolute right-3 top-3">
                                    <svg class="size-[18px]" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                         fill="currentColor">
                                        <path d="M11.9997 10.5865L16.9495 5.63672L18.3637 7.05093L13.4139 12.0007L18.3637 16.9504L16.9495 18.3646L11.9997 13.4149L7.04996 18.3646L5.63574 16.9504L10.5855 12.0007L5.63574 7.05093L7.04996 5.63672L11.9997 10.5865Z">
                                        </path>
                                    </svg>
                                </button>
                            </div>
                            <form class="w-full" id="editBranchForm">
                                @csrf
                                <input type="hidden" name="id" class="editId">
                                <!-- Company ID -->
                                <div class="flex gap-1 pb-4">
                                    <label class="text-sm font-medium text-gray-700">ID :</label>
                                    <span class="text-sm text-gray-600 flex w-[calc(100%-30px)] editBranchId"></span>
                                </div>

                                <!-- Active Status Toggle -->
                                <div class="flex items-center justify-between pb-4">
                                    <label class="text-sm font-medium text-gray-700">Active</label>
                                    <label class="relative gap-2 flex items-center cursor-pointer">
                                        <input type="checkbox" value="ACTIVE" name="status" class="sr-only peer"
                                               checked>
                                        <div class="relative w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-[#0073AF]">
                                        </div>
                                    </label>
                                </div>

                                <!-- Profile Picture Section -->
                                <div class="flex flex-col items-center">
                                    <div class="relative">
                                        <!-- Profile Image Preview Box -->
                                        <div id="preview-container"
                                             class="w-24 h-24 bg-gray-200 rounded-full flex items-center justify-center mb-2 overflow-hidden">
                                            <svg id="edit-default-icon" class="w-12 h-12 text-gray-400"
                                                 xmlns="http://www.w3.org/2000/svg"
                                                 viewBox="0 0 24 24" fill="currentColor">
                                                <path d="M12 12C14.7614 12 17 9.76142 17 7C17 4.23858 14.7614 2 12 2C9.23858 2 7 4.23858 7 7C7 9.76142 9.23858 12 12 12Z"/>
                                                <path d="M12 14C7.58172 14 4 17.5817 4 22H20C20 17.5817 16.4183 14 12 14Z"/>
                                            </svg>
                                            <img id="edit-preview-image" src="" alt="Preview"
                                                 class="hidden w-full h-full object-cover"/>
                                        </div>

                                        <!-- File Input (hidden) -->
                                        <input type="file" id="edit-file-input" accept="image/*" class="hidden"
                                               name="image"/>

                                        <!-- Upload Button -->
                                        <label for="edit-file-input"
                                               class="absolute -bottom-0 -right-0 w-8 h-8 bg-[#0073AF] rounded-full flex items-center justify-center hover:bg-[#0068A0] transition-colors text-white cursor-pointer">
                                            <svg class="size-[18px]" xmlns="http://www.w3.org/2000/svg"
                                                 viewBox="0 0 24 24" fill="currentColor">
                                                <path d="M9 3H15L17 5H21C21.5523 5 22 5.44772 22 6V20C22 20.5523 21.5523 21 21 21H3C2.44772 21 2 20.5523 2 20V6C2 5.44772 2.44772 5 3 5H7L9 3ZM12 19C15.3137 19 18 16.3137 18 13C18 9.68629 15.3137 7 12 7C8.68629 7 6 9.68629 6 13C6 16.3137 8.68629 19 12 19ZM12 17C9.79086 17 8 15.2091 8 13C8 10.7909 9.79086 9 12 9C14.2091 9 16 10.7909 16 13C16 15.2091 14.2091 17 12 17Z"></path>
                                            </svg>
                                        </label>
                                    </div>
                                </div>

                                <!-- Company Name -->
                                <div class="flex flex-col gap-1 pb-4">
                                    <label class="block text-sm font-medium text-gray-700">Name</label>
                                    <input type="text" value="" name="branch_name"
                                           class="edit-branch_name w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                           placeholder="Company Name">
                                </div>

                                <!-- Subdealer Selection -->
                                <div class="flex flex-col gap-1 pb-4">
                                    <label class="block text-sm font-medium text-gray-700">
                                        {{ trans_message('subdealer') }}
                                    </label>

                                    <div class="relative">
                                        <select
                                            id="editSubdealerSelect"
                                            name="subdealer_id"
                                            class="w-full px-4 py-3 border border-gray-300 rounded-lg bg-white
                focus:outline-none focus:ring-2 focus:ring-blue-500
                focus:border-transparent appearance-none"
                                        >
                                            <option value="">{{ trans_message('default_mysteryvisits') }}</option>
                                            @foreach($subdealers as $subdealer)
                                                <option value="{{ $subdealer->id }}">
                                                    {{ $subdealer->name }}
                                                </option>
                                            @endforeach
                                        </select>

                                        <!-- Arrow -->
                                        <div class="pointer-events-none absolute inset-y-0 right-3 flex items-center text-gray-500">
                                            <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none"
                                                 viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                      stroke-width="2" d="M19 9l-7 7-7-7" />
                                            </svg>
                                        </div>
                                    </div>
                                </div>

                                <!-- Company Address -->
                                <div class="grid sm:grid-cols-2 gap-4 pb-4">
                                    <div class="flex flex-col gap-1 col-span-2">
                                        <label class="block text-sm font-medium text-gray-700">Address Line 1</label>
                                        <input type="text"
                                               value=""
                                               name="address_1"
                                               class="edit-address_1 w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                               placeholder="Address Line 1">
                                    </div>
                                    <div class="flex flex-col gap-1">
                                        <label class="block text-sm font-medium text-gray-700">Locality</label>
                                        <input type="text" value="" name="locality"
                                               class="edit-locality w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                               placeholder="Locality">
                                    </div>
                                    <div class="flex flex-col gap-1">
                                        <label class="block text-sm font-medium text-gray-700">Postal Code</label>
                                        <input type="text" value="" name="postal_code"
                                               class="edit-postal_code w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                               placeholder="Postal Code">
                                    </div>
                                </div>

                                <!-- Upselling -->
                                <div class="grid sm:grid-cols-2 gap-4 pb-4">
                                    <div class="flex flex-col gap-1">
                                        <label class="block text-sm font-medium text-gray-700">Upselling Input</label>
                                        <input type="text" value="" name="upselling_input_url"
                                               class="edit-upselling_input_url w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                               placeholder="Upselling Input">
                                    </div>
                                    <div class="flex flex-col gap-1">
                                        <label class="block text-sm font-medium text-gray-700">Upselling Report</label>
                                        <input type="text" value="" name="upselling_report_url"
                                               class="edit-upselling_report_url w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                               placeholder="Upselling Report">
                                    </div>
                                </div>

                                <!-- 46% -->
                                <div class="grid sm:grid-cols-3 gap-4 pb-4">
                                    <div class="flex flex-col gap-1">
                                        <label class="block text-sm font-medium text-gray-700">46% Input</label>
                                        <input type="text" value="" name="input_url_46"
                                               class="edit-input_url_46 w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                               placeholder="46% Input">
                                    </div>
                                    <div class="flex flex-col gap-1">
                                        <label class="block text-sm font-medium text-gray-700">46% Report</label>
                                        <input type="text" value="" name="report_url_46"
                                               class="edit-report_url_46 w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                               placeholder="46% Report">
                                    </div>
                                    <div class="flex flex-col gap-1">
                                        <label class="block text-sm font-medium text-gray-700">Route</label>
                                        <div class="relative">
                                            <select name="route"
                                                    class="edit-route w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent appearance-none">
                                                <option>{{ \App\Enums\BranchRoutes::STANDARD->value }}</option>
                                                <option>{{ \App\Enums\BranchRoutes::LIPTON->value }}</option>
                                                <option>{{ \App\Enums\BranchRoutes::VRUMONA->value }}</option>
                                                <option>{{ \App\Enums\BranchRoutes::HEINEKEN->value }}</option>
                                            </select>
                                            <svg class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-500 size-[16px] sm:size-[20px] pointer-events-none"
                                                 xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                 fill="currentColor">
                                                <path d="M11.9999 13.1714L16.9497 8.22168L18.3639 9.63589L11.9999 15.9999L5.63599 9.63589L7.0502 8.22168L11.9999 13.1714Z">
                                                </path>
                                            </svg>
                                        </div>
                                    </div>
                                </div>

                                <!-- Action Buttons -->
                                <div class="grid grid-cols-[1fr_1fr] gap-3 pt-4 w-full">
                                    <button type="button" command="close" commandfor="edit-branch-model"
                                            class="btn-secondary modal-cancel px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 border border-gray-300 rounded-lg hover:bg-gray-200 cursor-pointer focus:outline-none focus:ring-2 focus:ring-gray-500 transition-all duration-300 modal-cancel">
                                        Cancel
                                    </button>
                                    <button type="submit"
                                            class="btn-primary px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-blue-600 rounded-lg hover:bg-blue-700 cursor-pointer focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all duration-300 flex justify-center"
                                            id="editBranchBtn">
                                        Save
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </el-dialog-panel>
            </div>
        </dialog>
    </el-dialog>

    <!-- Contact Person Model -->
    <el-dialog>
        <dialog id="contact-person" aria-labelledby="dialog-title"
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
                                <h3 id="edit-contact-person-dialog-title" class="text-base font-semibold text-gray-800">
                                    Contact Person
                                </h3>
                                <button type="button" command="close" commandfor="contact-person"
                                        class="rounded-full p-2 text-gray-800 hover:bg-gray-200 transition-all duration-300 cursor-pointer absolute right-3 top-3">
                                    <svg class="size-[18px]" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                         fill="currentColor">
                                        <path d="M11.9997 10.5865L16.9495 5.63672L18.3637 7.05093L13.4139 12.0007L18.3637 16.9504L16.9495 18.3646L11.9997 13.4149L7.04996 18.3646L5.63574 16.9504L10.5855 12.0007L5.63574 7.05093L7.04996 5.63672L11.9997 10.5865Z">
                                        </path>
                                    </svg>
                                </button>
                            </div>
                            <div class="w-full">
                                <!-- Contact Person Card -->
                                <div class="flex flex-col gap-3 contact_person_list">

                                </div>
                                <div class=" pt-5 pb-3">
                                    <button type="button"
                                            class="add_contact_person_btn btn-secondary w-full px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 border border-gray-300 rounded-lg hover:bg-gray-200 cursor-pointer focus:outline-none focus:ring-2 focus:ring-gray-500 transition-all duration-300">
                                        Add More
                                    </button>
                                </div>
                                <!-- Action Buttons -->
                                <div class="grid grid-cols-[1fr_1fr] gap-3 pt-4 w-full">
                                    <button type="button" command="close" commandfor="contact-person"
                                            class="btn-secondary px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 border border-gray-300 rounded-lg hover:bg-gray-200 cursor-pointer focus:outline-none focus:ring-2 focus:ring-gray-500 transition-all duration-300">
                                        Cancel
                                    </button>
                                    <button type="button" command="close" commandfor="contact-person"
                                            class="btn-primary px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-blue-600 rounded-lg hover:bg-blue-700 cursor-pointer focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all duration-300">
                                        Save
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </el-dialog-panel>
            </div>
        </dialog>
    </el-dialog>

    <!-- New Contact Person Model -->
    <el-dialog>
        <dialog id="contact-person-model" aria-labelledby="dialog-title"
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
                                <h3 id="contact-person-dialog-title" class="text-base font-semibold text-gray-800">
                                    New Contact Person</h3>
                                <button type="button" command="close" commandfor="contact-person-model"
                                        class="rounded-full p-2 text-gray-800 hover:bg-gray-200 transition-all duration-300 cursor-pointer absolute right-3 top-3">
                                    <svg class="size-[18px]" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                         fill="currentColor">
                                        <path d="M11.9997 10.5865L16.9495 5.63672L18.3637 7.05093L13.4139 12.0007L18.3637 16.9504L16.9495 18.3646L11.9997 13.4149L7.04996 18.3646L5.63574 16.9504L10.5855 12.0007L5.63574 7.05093L7.04996 5.63672L11.9997 10.5865Z">
                                        </path>
                                    </svg>
                                </button>
                            </div>
                            <form class="w-full" id="addContactPersonForm">
                                @csrf
                                <input type="hidden" name="branch_id" class="person_branch_id">
                                <!-- Name -->
                                <div class="flex flex-col gap-1 pb-4">
                                    <label class="block text-sm font-medium text-gray-700">First Name<span
                                                class="text-[red]">*</span></label>
                                    <input type="text" value="" name="first_name" maxlength="20"
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                           placeholder="First Name">
                                    <label id="first_name-error" class="text-[red] error" for="first_name"></label>
                                </div>
                                <!-- Last Name -->
                                <div class="flex flex-col gap-1 pb-4">
                                    <label class="block text-sm font-medium text-gray-700">Last Name<span
                                                class="text-[red]">*</span></label>
                                    <input type="text" value="" name="last_name" maxlength="20"
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                           placeholder="Last Name">
                                    <label id="last_name-error" class="text-[red] error" for="last_name"></label>
                                </div>

                                <!-- Email -->
                                <div class="flex flex-col gap-1 pb-4">
                                    <label class="block text-sm font-medium text-gray-700">Email<span
                                                class="text-[red]">*</span></label>
                                    <input type="email" value="" name="email"
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                           placeholder="Email">
                                    <label id="email-error" class="text-[red] error" for="email"></label>
                                </div>

                                <!-- Phone -->
                                <div class="flex flex-col gap-1 pb-4">
                                    <label class="block text-sm font-medium text-gray-700">Phone<span
                                                class="text-[red]">*</span></label>
                                    <input type="tel" value="" name="mobile_number"
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                           placeholder="Phone">
                                    <label id="mobile_number-error" class="text-[red] error"
                                           for="mobile_number"></label>
                                </div>

                                <!-- Action Buttons -->
                                <div class="grid grid-cols-[1fr_1fr] gap-3 pt-4 w-full">
                                    <button type="button" command="close" commandfor="contact-person-model"
                                            class="btn-secondary px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 border border-gray-300 rounded-lg hover:bg-gray-200 cursor-pointer focus:outline-none focus:ring-2 focus:ring-gray-500 transition-all duration-300">
                                        Cancel
                                    </button>
                                    <button type="submit"
                                            class="addContactPersonBtn btn-primary px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-blue-600 rounded-lg hover:bg-blue-700 cursor-pointer focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all duration-300 flex justify-center">
                                        Save
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </el-dialog-panel>
            </div>
        </dialog>
    </el-dialog>

    <!-- edit Contact Person Model -->
    <el-dialog>
        <dialog id="contact-person-edit" aria-labelledby="dialog-title"
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
                                <h3 id="contact-person-dialog-title" class="text-base font-semibold text-gray-800">
                                    Edit Contact Person</h3>
                                <button type="button" command="close" commandfor="contact-person-edit"
                                        class="rounded-full p-2 text-gray-800 hover:bg-gray-200 transition-all duration-300 cursor-pointer absolute right-3 top-3">
                                    <svg class="size-[18px]" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                         fill="currentColor">
                                        <path d="M11.9997 10.5865L16.9495 5.63672L18.3637 7.05093L13.4139 12.0007L18.3637 16.9504L16.9495 18.3646L11.9997 13.4149L7.04996 18.3646L5.63574 16.9504L10.5855 12.0007L5.63574 7.05093L7.04996 5.63672L11.9997 10.5865Z">
                                        </path>
                                    </svg>
                                </button>
                            </div>
                            <form class="w-full" id="editContactPersonForm">
                                @csrf
                                <input type="hidden" name="id" class="id">
                                <!-- Name -->
                                <div class="flex flex-col gap-1 pb-4">
                                    <label class="block text-sm font-medium text-gray-700">First Name<span
                                                class="text-[red]">*</span></label>
                                    <input type="text" value="" name="first_name" maxlength="20"
                                           class="first_name w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                           placeholder="First Name">
                                    <label id="first_name-error" class="text-[red] error" for="first_name"></label>
                                </div>
                                <!-- Last Name -->
                                <div class="flex flex-col gap-1 pb-4">
                                    <label class="block text-sm font-medium text-gray-700">Last Name<span
                                                class="text-[red]">*</span></label>
                                    <input type="text" value="" name="last_name" maxlength="20"
                                           class="last_name w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                           placeholder="Last Name">
                                    <label id="last_name-error" class="text-[red] error" for="last_name"></label>
                                </div>

                                <!-- Email -->
                                <div class="flex flex-col gap-1 pb-4">
                                    <label class="block text-sm font-medium text-gray-700">Email<span
                                                class="text-[red]">*</span></label>
                                    <input type="email" value="" name="email"
                                           class="email w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                           placeholder="Email">
                                    <label id="email-error" class="text-[red] error" for="email"></label>
                                </div>

                                <!-- Phone -->
                                <div class="flex flex-col gap-1 pb-4">
                                    <label class="block text-sm font-medium text-gray-700">Phone<span
                                                class="text-[red]">*</span></label>
                                    <input type="tel" value="" name="mobile_number"
                                           class="mobile_number w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                           placeholder="Phone">
                                    <label id="mobile_number-error" class="text-[red] error"
                                           for="mobile_number"></label>
                                </div>

                                <!-- Action Buttons -->
                                <div class="grid grid-cols-[1fr_1fr] gap-3 pt-4 w-full">
                                    <button type="button" command="close" commandfor="contact-person-edit"
                                            class="btn-secondary px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 border border-gray-300 rounded-lg hover:bg-gray-200 cursor-pointer focus:outline-none focus:ring-2 focus:ring-gray-500 transition-all duration-300">
                                        Cancel
                                    </button>
                                    <button type="submit"
                                            class="btn-primary px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-blue-600 rounded-lg hover:bg-blue-700 cursor-pointer focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all duration-300 flex justify-center"
                                            id="editContactPersonBtn">
                                        Save
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </el-dialog-panel>
            </div>
        </dialog>
    </el-dialog>

@endpush

@section('main')

    <section class="pt-4 sm:pt-6">
        <div class="flex flex-col md:flex-row items-center justify-end pb-6 gap-4">
            <div class="flex items-center gap-4 w-full md:w-auto">
                <div class="relative w-full md:w-auto">
                    <select id="filter-status"
                            class="filter-fields w-full appearance-none border border-[#e5e7eb] bg-gray-100 rounded-full px-4 py-2 sm:py-2.5 pr-8 text-sm sm:text-base text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">Show</option>
                        <option value="ACTIVE">Active</option>
                        <option value="INACTIVE">Inactive</option>
                    </select>
                    <svg class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-500 size-[16px] sm:size-[20px] pointer-events-none"
                         xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M11.9999 13.1714L16.9497 8.22168L18.3639 9.63589L11.9999 15.9999L5.63599 9.63589L7.0502 8.22168L11.9999 13.1714Z">
                        </path>
                    </svg>
                </div>
                <div class="relative w-full md:w-auto">
                    <select id="filter-sort_by"
                            class="filter-fields w-full appearance-none border border-[#e5e7eb] bg-gray-100 rounded-full px-4 py-2 sm:py-2.5 pr-8 text-sm sm:text-base text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
{{--                        <option value="">Sort by</option>--}}
                        <option value="id_desc">{{ trans_message('most_recent') }}</option>
                        <option value="id_asc">{{ trans_message('oldest') }}</option>
                        <option value="name_asc">Name (A-Z)</option>
                        <option value="name_desc">Name (Z-A)</option>
                    </select>
                    <svg class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-500 size-[16px] sm:size-[20px] pointer-events-none"
                         xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M11.9999 13.1714L16.9497 8.22168L18.3639 9.63589L11.9999 15.9999L5.63599 9.63589L7.0502 8.22168L11.9999 13.1714Z">
                        </path>
                    </svg>
                </div>
                <div class="relative w-full hidden lg:flex md:w-auto">
                    <button command="show-modal" commandfor="add-branch-model"
                            class="btn-primary w-full appearance-none border border-[#e5e7eb] bg-gray-100 rounded-full px-4 py-2.5 text-gray-700 cursor-pointer transition-all duration-300"
                            onclick="resetForm();">
                        <span>Add Branch</span>
                    </button>
                </div>
            </div>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-6 branchList">
            <!-- Branch Card -->
        </div>
    </section>

@endsection
@section('script')
    <script>
        var companyId = "{{ $companyId }}";

        const fileInput = document.getElementById("file-input");
        const previewImage = document.getElementById("preview-image");
        const defaultIcon = document.getElementById("default-icon");

        fileInput.addEventListener("change", function () {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    previewImage.src = e.target.result;
                    previewImage.classList.remove("hidden");
                    defaultIcon.classList.add("hidden");
                };
                reader.readAsDataURL(file);
            }
        });

        const editFileInput = document.getElementById("edit-file-input");
        const editPreviewImage = document.getElementById("edit-preview-image");
        const editDefaultIcon = document.getElementById("edit-default-icon");

        editFileInput.addEventListener("change", function () {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    editPreviewImage.src = e.target.result;
                    editPreviewImage.classList.remove("hidden");
                    editDefaultIcon.classList.add("hidden");
                };
                reader.readAsDataURL(file);
            }
        });

        function branchList() {
            var status = $('#filter-status').val();
            var sort_by = $('#filter-sort_by').val();
            $.ajax({
                url: "{{ route("admin.company.branches.list",["companyId" => $companyId]) }}",
                dataType: "JSON",
                method: "POST",
                data: {
                    "status": status,
                    "sort_by": sort_by,
                    "companyId": companyId,
                    "_token": "{{csrf_token()}}",
                },
                success: function (data) {
                    $('.branchList').html(data.message)
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

        branchList();

        function resetForm() {
            $("#addBranchForm").trigger('reset');
            $("#editBranchForm").trigger('reset');
            $("#addContactPersonForm").trigger('reset');
            $("#editContactPersonForm").trigger('reset');

            $("label.error").hide();
            $('#preview-image').addClass('hidden');
            $('#default-icon').removeClass('hidden');
            $('#edit-preview-image').addClass('hidden');
            $('#edit-default-icon').removeClass('hidden');
        }

        function removeBranch(id, element) {
            Swal.fire({
                title: "Are you sure?",
                text: "Are you sure you want to remove this branch?",
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
                        url: "{{route('admin.company.branches.delete',['companyId' => $companyId])}}",
                        dataType: "JSON",
                        method: "POST",
                        data: {
                            "id": id,
                            "_token": "{{csrf_token()}}",
                        },
                        success: function (data) {
                            sendSuccess(data.message);
                            branchList();
                        },
                        error: function (xhr) {
                            let data = xhr.responseJSON;
                            if (data.hasOwnProperty('error')) {
                                $.each(data.error, function (key, value) {
                                    $("#" + key + "-error").html(value).show();
                                });
                            } else if (data.hasOwnProperty('message')) {
                                actionError(xhr, data.message)
                            } else {
                                actionError(xhr);
                            }
                        }
                    });
                }
            });
        }

        function getBranch(id, element) {
            $.ajax({
                url: "{{route('admin.company.branches.edit',['companyId' => $companyId])}}",
                dataType: "JSON",
                method: "POST",
                data: {
                    "id": id,
                    "_token": "{{csrf_token()}}",
                },
                success: function (data) {
                    resetForm();

                    // Set image if exists
                    if (data.data.image) {
                        $('#edit-default-icon').addClass('hidden');
                        $('#edit-preview-image').removeClass('hidden');
                        $("#editBranchForm #edit-preview-image").attr('src', data.data.image).show();
                    }

                    $("#editBranchForm .editId").val(id);
                    $('#editBranchForm .editBranchId').html(data.data.branch_uid);

                    $('#editBranchForm .sr-only').removeAttr('checked');
                    if (data.data.status == 'ACTIVE') {
                        $('#editBranchForm .sr-only').attr('checked', 'checked');
                    }

                    $('#editBranchForm .edit-branch_name').val(data.data.branch_name);
                    $('#editBranchForm .edit-address_1').val(data.data.address_1);
                    $('#editBranchForm .edit-locality').val(data.data.locality);
                    $('#editBranchForm .edit-postal_code').val(data.data.postal_code);
                    $('#editBranchForm .edit-upselling_input_url').val(data.data.upselling_input_url);
                    $('#editBranchForm .edit-upselling_report_url').val(data.data.upselling_report_url);
                    $('#editBranchForm .edit-input_url_46').val(data.data.input_url_46);
                    $('#editBranchForm .edit-report_url_46').val(data.data.report_url_46);
                    $('#editBranchForm .edit-route').val(data.data.route);
                    $('#editSubdealerSelect').val(data.data.subdealer_id);

                    $('#edit-branch-model')[0].showModal();
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

        $(document).ready(function () {
            // Add Company Form
            $("#addBranchForm").validate({
                rules: {
                    branch_name: {required: true},
                },
                messages: {
                    branch_name: {required: "The branch name field is required."},
                },
                errorPlacement: function (error, element) {
                    element.after(error);
                },
                submitHandler: function (form, e) {
                    e.preventDefault();
                    $.ajax({
                        url: "{{route('admin.company.branches.add',['companyId' => $companyId])}}",
                        method: "post",
                        dataType: "json",
                        data: new FormData(form),
                        processData: false,
                        contentType: false,
                        cache: false,
                        beforeSend: function () {
                            $('#addBranchBtn').attr('disabled', true).html(`
                                <svg class="animate-spin h-4 w-4 text-white mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                Processing...
                            `);
                        },
                        success: function (result) {
                            $(".modal-cancel").click();
                            sendSuccess(result.message);
                            resetForm();
                        },
                        error: function (xhr) {
                            let data = xhr.responseJSON;
                            if (data.hasOwnProperty('error')) {
                                $.each(data.error, function (key, value) {
                                    $("#addBranchForm #" + key + "-error").html(value).show();
                                });
                            } else if (data.hasOwnProperty('message')) {
                                actionError(xhr, data.message);
                            } else {
                                actionError(xhr);
                            }
                        },
                        complete: function () {
                            $('#addBranchBtn').attr('disabled', false).html('save');
                            branchList();
                        },
                    });
                }
            });

            // Update Company Form
            $("#editBranchForm").validate({
                rules: {
                    branch_name: {required: true},
                },
                messages: {
                    branch_name: {required: "The branch name field is required."},
                },
                errorPlacement: function (error, element) {
                    element.after(error);
                },
                submitHandler: function (form, e) {
                    e.preventDefault();
                    $.ajax({
                        url: "{{route('admin.company.branches.update',['companyId' => $companyId])}}",
                        method: "post",
                        dataType: "json",
                        data: new FormData(form),
                        processData: false,
                        contentType: false,
                        cache: false,
                        beforeSend: function () {
                            $('#editBranchBtn').attr('disabled', true).html(`
                                <svg class="animate-spin h-4 w-4 text-white mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                Processing...
                            `);
                        },
                        success: function (result) {
                            $(".modal-cancel").click();
                            sendSuccess(result.message);
                            resetForm();
                        },
                        error: function (xhr) {
                            let data = xhr.responseJSON;
                            if (data.hasOwnProperty('error')) {
                                $.each(data.error, function (key, value) {
                                    $("#editBranchForm #" + key + "-error").html(value).show();
                                });
                            } else if (data.hasOwnProperty('message')) {
                                actionError(xhr, data.message);
                            } else {
                                actionError(xhr);
                            }
                        },
                        complete: function () {
                            $('#editBranchBtn').attr('disabled', false).html('save');
                            branchList();
                        },
                    });
                }
            });
        });

        $('.filter-fields').on('change', function (e) {
            branchList();
        });

        $('.add_contact_person_btn').on('click', function (e) {
            var id = $(this).attr('data-branch_id');
            $('#contact-person-model')[0].showModal();
            $('#addContactPersonForm .person_branch_id').val(id);
        });

        function branchContactList(id, element) {
            $.ajax({
                url: "{{route('admin.company.branch.users.list',['companyId' => $companyId])}}",
                dataType: "JSON",
                method: "POST",
                data: {
                    "id": id,
                    "_token": "{{csrf_token()}}",
                },
                success: function (data) {
                    $(".contact_person_list").html(data.data.html);
                    $(".add_contact_person_btn").attr('data-branch_id', data.data.branch_id);
                    $('#contact-person')[0].showModal();
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

        $(document).ready(function () {
            // Custom rule to allow only letters and spaces
            jQuery.validator.addMethod("lettersonly", function (value, element) {
                return this.optional(element) || /^[a-zA-Z\s]+$/.test(value);
            }, "Please enter letters only.");

            // Add Company Person Form
            $("#addContactPersonForm").validate({
                rules: {
                    first_name: {
                        required: true,
                        lettersonly: true
                    },
                    last_name: {
                        required: true,
                        lettersonly: true
                    },
                    email: {required: true},
                    mobile_number: {required: true},
                },
                messages: {
                    first_name: {
                        required: "The first name field is required.",
                        lettersonly: "The first name may only contain letters."
                    },
                    last_name: {
                        required: "The last name field is required.",
                        lettersonly: "The last name may only contain letters."
                    },
                    email: {required: "The email field is required."},
                    mobile_number: {required: "The mobile number field is required."},
                },
                errorPlacement: function (error, element) {
                    element.after(error);
                },
                submitHandler: function (form, e) {
                    e.preventDefault();
                    $.ajax({
                        url: "{{route('admin.company.branch.users.add',['companyId' => $companyId])}}",
                        method: "post",
                        dataType: "json",
                        data: new FormData(form),
                        processData: false,
                        contentType: false,
                        cache: false,
                        beforeSend: function () {
                            $('#addContactPersonBtn').attr('disabled', true).html(`
                                <svg class="animate-spin h-4 w-4 text-white mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                Processing...
                            `);
                        },
                        success: function (result) {
                            $('#contact-person-model')[0].close();
                            sendSuccess(result.message);
                            resetForm();
                            var id = $('.add_contact_person_btn').attr('data-branch_id');
                            branchContactList(id, this);
                        },
                        error: function (xhr) {
                            let data = xhr.responseJSON;
                            if (data.hasOwnProperty('error')) {
                                $.each(data.error, function (key, value) {
                                    $("#addContactPersonForm #" + key + "-error").html(value).show();
                                });
                            } else if (data.hasOwnProperty('message')) {
                                actionError(xhr, data.message);
                            } else {
                                actionError(xhr);
                            }
                        },
                        complete: function () {
                            $('#addContactPersonBtn').attr('disabled', false).html('save');
                        },
                    });
                }
            });

            // Update Company Person Form
            $("#editContactPersonForm").validate({
                rules: {
                    first_name: {
                        required: true,
                        lettersonly: true
                    },
                    last_name: {
                        required: true,
                        lettersonly: true
                    },
                    email: {required: true},
                },
                messages: {
                    first_name: {
                        required: "The first name field is required.",
                        lettersonly: "The first name may only contain letters."
                    },
                    last_name: {
                        required: "The last name field is required.",
                        lettersonly: "The last name may only contain letters."
                    },
                    email: {required: "The email field is required."},
                },
                errorPlacement: function (error, element) {
                    element.after(error);
                },
                submitHandler: function (form, e) {
                    e.preventDefault();
                    $.ajax({
                        url: "{{route('admin.company.branch.users.update',['companyId' => $companyId])}}",
                        method: "post",
                        dataType: "json",
                        data: new FormData(form),
                        processData: false,
                        contentType: false,
                        cache: false,
                        beforeSend: function () {
                            $('#editContactPersonBtn').attr('disabled', true).html(`
                                <svg class="animate-spin h-4 w-4 text-white mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                Processing...
                            `);
                        },
                        success: function (result) {
                            $('#contact-person-edit')[0].close();
                            sendSuccess(result.message);
                            resetForm();
                            var id = $('.add_contact_person_btn').attr('data-branch_id');
                            branchContactList(id, this);
                        },
                        error: function (xhr) {
                            let data = xhr.responseJSON;
                            if (data.hasOwnProperty('error')) {
                                $.each(data.error, function (key, value) {
                                    $("#editContactPersonForm #" + key + "-error").html(value).show();
                                });
                            } else if (data.hasOwnProperty('message')) {
                                actionError(xhr, data.message);
                            } else {
                                actionError(xhr);
                            }
                        },
                        complete: function () {
                            $('#editContactPersonBtn').attr('disabled', false).html('save');
                        },
                    });
                }
            });
        });

        // Remove company user
        function removeBranchContact(id, element) {
            $('#contact-person')[0].close();
            Swal.fire({
                title: "Are you sure?",
                text: "Are you sure you want to remove this contact?",
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
                        url: "{{route('admin.company.branch.users.delete',['companyId' => $companyId])}}",
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
                            sendSuccess(data.message);
                            // var id = $('.add_contact_person_btn').attr('data-branch_id');
                            branchContactList(id, this);
                        },
                        error: function (xhr) {
                            let data = xhr.responseJSON;
                            if (data.hasOwnProperty('error')) {
                                $.each(data.error, function (key, value) {
                                    $("#" + key + "-error").html(value).show();
                                });
                            } else if (data.hasOwnProperty('message')) {
                                actionError(xhr, data.message)
                            } else {
                                actionError(xhr);
                            }
                        },
                        complete: function () {
                            $(element).attr('disabled', false);
                        }
                    });
                } else {
                    branchContactList(id, this);
                }
            });
        }

        function getEditBranchContact(id, element) {
            $.ajax({
                url: "{{route('admin.company.branch.users.edit',['companyId' => $companyId])}}",
                dataType: "JSON",
                method: "POST",
                data: {
                    "id": id,
                    "_token": "{{csrf_token()}}",
                },
                success: function (data) {
                    resetForm();

                    $("#editContactPersonForm input[name=id]").val(data.data.id);
                    $('#editContactPersonForm input[name=first_name]').val(data.data.first_name);
                    $('#editContactPersonForm input[name=last_name]').val(data.data.last_name);
                    $('#editContactPersonForm input[name=email]').val(data.data.email);
                    $('#editContactPersonForm input[name=mobile_number]').val(data.data.mobile_number);

                    $('#contact-person-edit')[0].showModal();
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

    </script>
@endsection
