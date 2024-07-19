@php
    use App\Models\Data\Evaluasi;
    use App\Models\Data\JenisEvaluasi;
@endphp

<x-filament-panels::page>
    <div>
        {{-- <x-filament::input.wrapper class="mb-5">
            <x-filament::input.select wire:model="selectedPesertaTender">
                <option value="">Pilih Peserta Tender</option>
                @foreach ($pesertaTenders as $pesertaTender)
                    <option value="{{ $pesertaTender['id'] }}">{{ $pesertaTender['nama'] }}</option>
                @endforeach
            </x-filament::input.select>
        </x-filament::input.wrapper> --}}
        <x-filament::input.wrapper class="mb-5">
            <x-filament::input.select wire:model="selectedPaketTender">
                <option value="">Pilih Paket Tender</option>
                @foreach ($paketTenders as $paketTender)
                    <option value="{{ $paketTender['id'] }}">{{ $paketTender['kode_paket'] }} - {{ $paketTender['nama_paket'] }}</option>
                @endforeach
            </x-filament::input.select>
        </x-filament::input.wrapper>

        <x-filament::input.wrapper class="mb-5">
            <x-filament::input.select wire:model="selectedPerusahaan">
                <option value="">Pilih Perusahaan</option>
                @foreach ($perusahaans as $perusahaan)
                @php
                    // dd($perusahaan);
                @endphp
                    <option value="{{ $perusahaan['id'] }}">{{ $perusahaan['nama_perusahaan'] }}</option>
                @endforeach
            </x-filament::input.select>
        </x-filament::input.wrapper>

    </div>

    <div>
        <div class="bg-white shadow-sm fi-section rounded-xl ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10">
            <table class="table w-full text-sm border-collapse">
                <thead>
                    <tr class="divide-x divide-gray-950/5 dark:divide-white/10">
                        <th class="px-3 py-2">No</th>
                        <th class="px-3 py-2">Uraian Kualifikasi</th>
                        <th class="px-3 py-2" colspan="5">Nilai</th>
                        <th class="px-3 py-2">Bobot</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-950/5 dark:divide-white/10 text-center">
                    @foreach($listUraian as $uraian)
                        <tr class="divide-x divide-gray-950/5 dark:divide-white/10">
                            <td>{{ $uraian->no }}</td>
                            <td class="px-3 py-2 font-bold">{{ $uraian->uraian }}</td>
                            @foreach (range(1,5) as $item)
                                <td class="px-3 py-2">
                                    <x-filament::input.checkbox wire:model="isAdmin" />
                                    <span>{{ $item }}</span>
                                </td>
                            @endforeach
                            <td class="px-3 py-2 w-32">
                                <x-filament::input
                                    type="text"
                                    wire:model="name"
                                    class="text-center"
                                />
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-filament-panels::page>
