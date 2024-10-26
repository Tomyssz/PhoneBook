<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('PhoneBook') }}
            </h2>
            <a
                href="{{ route('phonebook.create') }}"
                class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                {{ __('Add new number') }}
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(count($phoneEntries))
                <table>
                    <thead>
                        <tr>
                            <th>{{ __('#') }}</th>
                            <th>{{ __('Name') }}</th>
                            <th>{{ __('Phone') }}</th>
                            <th colspan="2">{{ __('Actions') }}</th>
                        </tr>
                    </thead>
                    @foreach($phoneEntries as $phoneEntry)
                        <tr>
                            <td>
                                {{ $phoneEntry->id }}
                            </td>
                            <td>
                                {{ $phoneEntry->name }}
                            </td>
                            <td>
                                {{ $phoneEntry->phone }}
                            </td>
                            @if($phoneEntry->canUpdate())
                                <td>
                                    <form method="post" action="{{ route('phonebook.destroy', $phoneEntry->id) }}">
                                        @csrf
                                        @method('DELETE')
                                        <x-danger-button>{{ __('Delete') }}</x-danger-button>
                                    </form>
                                </td>
                                <td>
                                    <a href="{{ route('phonebook.edit', $phoneEntry->id) }}">
                                        <x-primary-button>{{ __('Edit') }}</x-primary-button>
                                    </a>
                                </td>
                            @endif
                        </tr>
                    @endforeach
                </table>
            @else
                <div>
                    {{ __('Your phonebook is empty') }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
