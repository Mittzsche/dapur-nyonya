<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PemesananRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'nama_pelanggan' => 'required|string|max:50',
            'no_hp' => 'required|string|max:15',
            'alamat' => 'required|string',
            'tanggal_acara' => 'required|date|after_or_equal:today',
            'catatan' => 'nullable|string',
            'id_layanan' => 'required|exists:tb_data_layanan,id_layanan',
            'id_mitra' => 'nullable|exists:tb_data_mitra,id_mitra',
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'nama_pelanggan.required' => 'Nama pelanggan wajib diisi',
            'nama_pelanggan.max' => 'Nama pelanggan maksimal 50 karakter',
            'no_hp.required' => 'Nomor HP/WA wajib diisi',
            'no_hp.max' => 'Nomor HP maksimal 15 karakter',
            'alamat.required' => 'Alamat pengiriman wajib diisi',
            'tanggal_acara.required' => 'Tanggal acara wajib diisi',
            'tanggal_acara.date' => 'Format tanggal tidak valid',
            'tanggal_acara.after_or_equal' => 'Tanggal acara tidak boleh di masa lalu',
            'id_layanan.required' => 'Pilih paket layanan',
            'id_layanan.exists' => 'Paket layanan tidak valid',
            'id_mitra.exists' => 'Mitra tidak valid',
        ];
    }
}
