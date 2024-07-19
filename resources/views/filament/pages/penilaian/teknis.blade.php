@php
    use App\Models\Data\Evaluasi;
    use App\Models\Data\JenisEvaluasi;

    $listJenisEvaluasi;


    $jenisEvaluasi = JenisEvaluasi::query()->where('nama_jenis', 'Evaluasi Teknis')->orderBy('no')->get();

    foreach ($jenisEvaluasi as $jenis) {
        $listUraian = Evaluasi::query()->where('jenis_evaluasi_id', $jenis->id)->orderBy('no')->get();

    }

@endphp
<x-filament-panels::page>
    <div>
        <div class="bg-white shadow-sm fi-section rounded-xl ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10">
            <table class="table w-full text-sm border-collapse">
                <tbody class="divide-y divide-gray-950/5 dark:divide-white/10">
                    <tr class="divide-x divide-gray-950/5 dark:divide-white/10">
                        <td class="px-3 py-2">Kode Perusahaan</td>
                        <td class="px-3 py-2">
                            <span class="text-xs text-gray-400">00111</span>
                            Suka maju
                        </td>
                    </tr>
                    <tr class="divide-x divide-gray-950/5 dark:divide-white/10">
                        <td class="px-3 py-2">Kode Paket</td>
                        <td class="px-3 py-2">
                            <span class="text-xs text-gray-400"> 00111</span>
                            Suka maju
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div>
        <div class="bg-white shadow-sm fi-section rounded-xl ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10">
            <table class="table w-full text-sm border-collapse">
                <thead>
                    <tr class="divide-x divide-gray-950/5 dark:divide-white/10">
                        <th class="px-3 py-2">No</th>
                        <th class="px-3 py-2">Uraian Teknis</th>
                        <th class="px-3 py-2" colspan="5">Nilai</th>
                        <th class="px-3 py-2">Bobot</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-950/5 dark:divide-white/10 text-center">
                    @foreach($listUraian as $index => $value)
                        <tr class="divide-x divide-gray-950/5 dark:divide-white/10">
                            <td>{{ $value->no }}</td>
                            <td class="px-3 py-2 font-bold">{{ $value->uraian }}</td>
                                @foreach (range(1,5) as $item)
                                <td class="px-3 py-2">
                                    <x-filament::input.checkbox wire:model="isAdmin" />
                                        <span>
                                            {{ $item }}
                                        </span>
                                </td>
                            @endforeach
                            <td class="px-3 py-2 w-32">
                                <x-filament::input
                                    type="text"
                                    wire:model="name"
                                    class="text-center"
                                />
                            </td>
                        @endforeach

                        </tr>
                        {{-- @foreach ($listUraian as $uraian) --}}
                            {{-- <tr class="px-3 py-2">{{ $uraian->uraian }} --}}
                                {{-- @endforeach --}}
                            {{-- </tr> --}}


                </tbody>
            </table>
        </div>
    </div>
</x-filament-panels::page>
