
{{--checkbox--}}
<input type="checkbox" class="rounded-sm text-primary dark:text-info bg-transparent border-[2px] border-dark/30 dark:border-light/30 focus:ring-0 focus:outline-none">

{{--input field with label--}}
{{--just copy the class for all other fiels like textarea, etc--}}
<div class="flex flex-col gap-1">
    <label for="role" class="font-semibold text-sm text-dark/80 dark:text-light/80">Role</label>
    <input type="text" placeholder="Enter Role Name..." class="px-4 py-1.5 bg-transparent border-[1px] text-dark/80 dark:text-light/80 border-dark/50 dark:border-light/50 hover:border-dark/90 dark:hover:border-light/90 focus:border-dark/90 dark:focus:border-light/90  rounded-[3px] focus:outline-none focus:ring-0 transition ease-in duration-2000">
</div>

{{--for select input field--}}
<div class="flex flex-col gap-1">
    <label for="role" class="font-semibold text-sm text-dark/80 dark:text-light/80">Gender</label>
    <select
        class="px-4 py-1.5 border-[1px] text-dark/80 dark:text-light/80 border-dark/50 dark:border-light/50 hover:border-dark/90 dark:hover:border-light/90 focus:border-dark/90 dark:focus:border-light/90 rounded-[3px] focus:outline-none focus:ring-0 transition ease-in duration-2000 appearance-none bg-light dark:bg-darkTrans ">
        <option value="">--Select Gender--</option>
        <option value="male">Male</option>
        <option value="female">Female</option>
        <option value="other">Other</option>
    </select>
</div>

{{--add new / form submit button --}}
<button class="text-sm px-4 py-1 rounded-sm font-semibold bg-gradient-to-r hover:bg-gradient-to-b from-primary to-primary/70 dark:from-info/50 dark:to-info/80 text-white hover:scale-105 transition ease-in duration-2000">Submit </button>

{{--dull , cancel button--}}
<button class="text-sm px-4 py-1 rounded-sm font-semibold bg-gradient-to-r hover:bg-gradient-to-b from-dark/40 to-dark/60 dark:from-light/20 dark:to-light/40 text-white hover:scale-105 transition ease-in duration-2000">Cancel </button>

{{--table code--}}
<div class="mt-2 w-full bg-light dark:bg-darkTrans shadow-lg shadow-dark/10 dark:shadow-dark rounded-[10px] flex flex-col justify-between p-6 overflow-x-auto">
    <table class="border-collapse border-[1px] border-dark/30 dark:border-light/30 w-full">
        <tr class="bg-lightTrans dark:bg-dark">
            <th class="text-left border-[1px] border-dark/30 dark:border-light/30 px-2 py-2 text-md text-dark/80 dark:text-light/80 font-normal">SR.No.</th>
            <th class="text-left border-[1px] border-dark/30 dark:border-light/30 px-2 py-2 text-md text-dark/80 dark:text-light/80 font-normal">NAME</th>
            <th class="text-left border-[1px] border-dark/30 dark:border-light/30 px-2 py-2 text-md text-dark/80 dark:text-light/80 font-normal">EMAIL</th>
            <th class="text-left border-[1px] border-dark/30 dark:border-light/30 px-2 py-2 text-md text-dark/80 dark:text-light/80 font-normal">Address</th>
            <th class="text-left border-[1px] border-dark/30 dark:border-light/30 px-2 py-2 text-md text-dark/80 dark:text-light/80 font-normal">ACTION</th>
        </tr>
        <tr>
            <th class="text-left border-[1px] border-dark/30 dark:border-light/30 px-2 py-1 text-sm text-dark/80 dark:text-light/80 font-normal">
                <p>1</p>
            </th>
            <th class="text-left border-[1px] border-dark/30 dark:border-light/30 px-2 py-1 text-sm text-dark/80 dark:text-light/80 font-normal">
                <div class="flex flex-col">
                    <span class="text-sm font-bold cursor-pointer">Alice</span>
                </div>
            </th>
            <th class="text-left border-[1px] border-dark/30 dark:border-light/30 px-2 py-1 text-sm text-dark/80 dark:text-light/80 font-normal">
                <p>alice@example.com</p>
            </th>
            <th class="text-left border-[1px] border-dark/30 dark:border-light/30 px-2 py-1 text-sm text-dark/80 dark:text-light/80 font-normal">
                <p>New York</p>
            </th>
            <th class="text-left border-[1px] border-dark/30 dark:border-light/30 px-2 py-1 text-sm text-dark/80 dark:text-light/80 font-normal">
                <div class="flex">
                    <button class="h-8 w-8 rounded-full text-success hover:bg-success/20 text-md font-semibold cursor-pointer transition ease-in duration-2000" title="View">
                        <i class="fa-regular fa-eye text-md"></i>
                    </button>
                    <button class="h-8 w-8 rounded-full text-info hover:bg-info/20 text-md font-semibold cursor-pointer transition ease-in duration-2000" title="Edit">
                        <i class="fa-regular fa-edit text-md"></i>
                    </button>
                    <button class="h-8 w-8 rounded-full text-danger hover:bg-danger/20 text-md font-semibold cursor-pointer transition ease-in duration-2000" title="Delete">
                        <i class="fa-regular fa-trash-can text-md"></i>
                    </button>
                </div>
            </th>
        </tr>
        <tr class="bg-lightTrans/40 dark:bg-dark/40">
            <th class="text-left border-[1px] border-dark/30 dark:border-light/30 px-2 py-1 text-sm text-dark/80 dark:text-light/80 font-normal">
                <p>2</p>
            </th>
            <th class="text-left border-[1px] border-dark/30 dark:border-light/30 px-2 py-1 text-sm text-dark/80 dark:text-light/80 font-normal">
                <div class="flex flex-col">
                    <span class="text-sm font-bold cursor-pointer">Bob</span>
                </div>
            </th>
            <th class="text-left border-[1px] border-dark/30 dark:border-light/30 px-2 py-1 text-sm text-dark/80 dark:text-light/80 font-normal">
                <p>bob@example.com</p>
            </th>
            <th class="text-left border-[1px] border-dark/30 dark:border-light/30 px-2 py-1 text-sm text-dark/80 dark:text-light/80 font-normal">
                <p>Los Angeles</p>
            </th>
            <th class="text-left border-[1px] border-dark/30 dark:border-light/30 px-2 py-1 text-sm text-dark/80 dark:text-light/80 font-normal">
                <div class="flex">
                    <button class="h-8 w-8 rounded-full text-success hover:bg-success/20 text-md font-semibold cursor-pointer transition ease-in duration-2000" title="View">
                        <i class="fa-regular fa-eye text-md"></i>
                    </button>
                    <button class="h-8 w-8 rounded-full text-info hover:bg-info/20 text-md font-semibold cursor-pointer transition ease-in duration-2000" title="Edit">
                        <i class="fa-regular fa-edit text-md"></i>
                    </button>
                    <button class="h-8 w-8 rounded-full text-danger hover:bg-danger/20 text-md font-semibold cursor-pointer transition ease-in duration-2000" title="Delete">
                        <i class="fa-regular fa-trash-can text-md"></i>
                    </button>
                </div>
            </th>
        </tr>
        <tr>
            <th class="text-left border-[1px] border-dark/30 dark:border-light/30 px-2 py-1 text-sm text-dark/80 dark:text-light/80 font-normal">
                <p>3</p>
            </th>
            <th class="text-left border-[1px] border-dark/30 dark:border-light/30 px-2 py-1 text-sm text-dark/80 dark:text-light/80 font-normal">
                <div class="flex flex-col">
                    <span class="text-sm font-bold cursor-pointer">Charlie</span>
                </div>
            </th>
            <th class="text-left border-[1px] border-dark/30 dark:border-light/30 px-2 py-1 text-sm text-dark/80 dark:text-light/80 font-normal">
                <p>charlie@example.com</p>
            </th>
            <th class="text-left border-[1px] border-dark/30 dark:border-light/30 px-2 py-1 text-sm text-dark/80 dark:text-light/80 font-normal">
                <p>Chicago</p>
            </th>
            <th class="text-left border-[1px] border-dark/30 dark:border-light/30 px-2 py-1 text-sm text-dark/80 dark:text-light/80 font-normal">
                <div class="flex">
                    <button class="h-8 w-8 rounded-full text-success hover:bg-success/20 text-md font-semibold cursor-pointer transition ease-in duration-2000" title="View">
                        <i class="fa-regular fa-eye text-md"></i>
                    </button>
                    <button class="h-8 w-8 rounded-full text-info hover:bg-info/20 text-md font-semibold cursor-pointer transition ease-in duration-2000" title="Edit">
                        <i class="fa-regular fa-edit text-md"></i>
                    </button>
                    <button class="h-8 w-8 rounded-full text-danger hover:bg-danger/20 text-md font-semibold cursor-pointer transition ease-in duration-2000" title="Delete">
                        <i class="fa-regular fa-trash-can text-md"></i>
                    </button>
                </div>
            </th>
        </tr>
    </table>
</div>

