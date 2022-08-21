<?php

namespace Database\Seeders;

use App\Models\Configuration;
use Illuminate\Database\Seeder;

class ConfigurationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Configuration::set("title", "Pemilihan Ketua OSIS");
        Configuration::set(
            "subtitle",
            "SMA Negeri 1 Magelang periode 2021 - 2022"
        );
        Configuration::set("hide_osis_mpk", "false");
        Configuration::set("hide_from_public", "false");
        Configuration::set("cover_image", "");
        Configuration::set(
            "confirmation_message",
            "Sebagai ketua OSIS SMA Negeri 1 Magelang periode 2021 - 2022"
        );
        Configuration::set(
            "thanks_message",
            "Terima kasih telah berpartisipasi dalam pemilihan ketua OSIS SMA Negeri 1 Magelang periode 2021 - 2022."
        );
        Configuration::set("thanks_page_timeout", "3000");
    }
}
