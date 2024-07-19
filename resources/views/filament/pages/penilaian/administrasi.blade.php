@php
    use App\Models\Data\Evaluasi;
    use App\Models\Data\JenisEvaluasi;
    use App\Models\Data\Perusahaan;
    use App\Models\PesertaTender;

@endphp

<x-filament-panels::page>
    <div>
        <x-filament::input.wrapper class="mb-5">
            <x-filament::input.select wire:model="selectedPaketTender">
                <option value="">Pilih Paket Tender</option>
                @foreach ($paketTender as $items)
                    <option value="{{ $items['id'] }}">{{ $items['kode_paket'] }} - {{ $items['nama_paket'] }}</option>
                @endforeach
            </x-filament::input.select>
        </x-filament::input.wrapper>

        <x-filament::input.wrapper class="mb-5">
            <x-filament::input.select wire:model="selectedPerusahaan">
                <option value="">Pilih Perusahaan</option>
                @foreach ($peserta as $perusahaan)
                    <option value="{{ $perusahaan['id'] }}">{{ $perusahaan['perusahaan']['nama_perusahaan'] }}</option>
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
                        <th class="px-3 py-2">Uraian Administrasi</th>
                        <th class="px-3 py-2">Nilai</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-950/5 dark:divide-white/10 text-center">
                    @foreach($listUraian as $uraian)
                        <tr class="divide-x divide-gray-950/5 dark:divide-white/10">
                            <td>{{ $uraian->no }}</td>
                            <td class="px-3 py-2 font-bold">{{ $uraian->uraian }}</td>
                                <td class="px-3 py-2">
                                    <x-filament::input.radio wire:model="isAdmin" />
                                    <span>Sesuai</span>
                                </td>
                                <td class="px-3 py-2">
                                    <x-filament::input.radio wire:model="isAdmin" />
                                    <span>Tidak Sesuai</span>
                                </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-filament-panels::page>
