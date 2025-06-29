<?php

namespace App\Utils;

class PermissionDictionary
{

    /**
     * KETERANGAN
     *
     * name => untuk nama permission yang akan di gunakan di sistem untuk pengecekkan
     * menu => untuk nama menu. ditandai dengan hanya memuat satu nama permission. seperti Customer Database dan Marketing Activity
     * group => untuk menandai jenis permission masuk ke group akses apa [api, web, admin]
     * type => untuk menandai jenis permission masuk type permission apa menggunakan format integer [1:read, 2:create, 3:edit, 4:delete, 5:approve/publish/action]
     */
    const PERMISSION = [
        ['name' => 'bill>read', 'menu' => 'Tagihan', 'group' => 'admin', 'type' => 1],
        ['name' => 'bill>create', 'menu' => 'Tagihan', 'group' => 'admin', 'type' => 2],
        ['name' => 'bill>edit', 'menu' => 'Tagihan', 'group' => 'admin', 'type' => 3],
        ['name' => 'bill>delete', 'menu' => 'Tagihan', 'group' => 'admin', 'type' => 4],

        ['name' => 'bill>type>read', 'menu' => 'Type Tagihan', 'group' => 'admin', 'type' => 1],
        ['name' => 'bill>type>create', 'menu' => 'Type Tagihan', 'group' => 'admin', 'type' => 2],
        ['name' => 'bill>type>edit', 'menu' => 'Type Tagihan', 'group' => 'admin', 'type' => 3],
        ['name' => 'bill>type>delete', 'menu' => 'Type Tagihan', 'group' => 'admin', 'type' => 4],

        ['name' => 'payment>read', 'menu' => 'Pembayaran Tagihan', 'group' => 'admin', 'type' => 1],
        ['name' => 'payment>action', 'menu' => 'Pembayaran Tagihan', 'group' => 'admin', 'type' => 5],

        ['name' => 'article>read', 'menu' => 'Post Artikel', 'group' => 'admin', 'type' => 1],
        ['name' => 'article>create', 'menu' => 'Post Artikel', 'group' => 'admin', 'type' => 2],
        ['name' => 'article>edit', 'menu' => 'Post Artikel', 'group' => 'admin', 'type' => 3],
        ['name' => 'article>delete', 'menu' => 'Post Artikel', 'group' => 'admin', 'type' => 4],

        ['name' => 'promotion>read', 'menu' => 'Post Promosi', 'group' => 'admin', 'type' => 1],
        ['name' => 'promotion>create', 'menu' => 'Post Promosi', 'group' => 'admin', 'type' => 2],
        ['name' => 'promotion>edit', 'menu' => 'Post Promosi', 'group' => 'admin', 'type' => 3],
        ['name' => 'promotion>delete', 'menu' => 'Post Promosi', 'group' => 'admin', 'type' => 4],

        ['name' => 'banner>read', 'menu' => 'Post Banner', 'group' => 'admin', 'type' => 1],
        ['name' => 'banner>create', 'menu' => 'Post Banner', 'group' => 'admin', 'type' => 2],
        ['name' => 'banner>edit', 'menu' => 'Post Banner', 'group' => 'admin', 'type' => 3],
        ['name' => 'banner>delete', 'menu' => 'Post Banner', 'group' => 'admin', 'type' => 4],

        ['name' => 'complain>read', 'menu' => 'Complain User', 'group' => 'admin', 'type' => 1],
        ['name' => 'complain>action', 'menu' => 'Complain User', 'group' => 'admin', 'type' => 5],

        ['name' => 'project>read', 'menu' => 'Project', 'group' => 'admin', 'type' => 1],
        ['name' => 'project>create', 'menu' => 'Project', 'group' => 'admin', 'type' => 2],
        ['name' => 'project>edit', 'menu' => 'Project', 'group' => 'admin', 'type' => 3],
        ['name' => 'project>delete', 'menu' => 'Project', 'group' => 'admin', 'type' => 4],

        ['name' => 'area>read', 'menu' => 'Project Area', 'group' => 'admin', 'type' => 1],
        ['name' => 'area>create', 'menu' => 'Project Area', 'group' => 'admin', 'type' => 2],
        ['name' => 'area>edit', 'menu' => 'Project Area', 'group' => 'admin', 'type' => 3],
        ['name' => 'area>delete', 'menu' => 'Project Area', 'group' => 'admin', 'type' => 4],

        ['name' => 'bloc>read', 'menu' => 'Project Bloc', 'group' => 'admin', 'type' => 1],
        ['name' => 'bloc>create', 'menu' => 'Project Bloc', 'group' => 'admin', 'type' => 2],
        ['name' => 'bloc>edit', 'menu' => 'Project Bloc', 'group' => 'admin', 'type' => 3],
        ['name' => 'bloc>delete', 'menu' => 'Project Bloc', 'group' => 'admin', 'type' => 4],

        ['name' => 'unit>read', 'menu' => 'Project Unit', 'group' => 'admin', 'type' => 1],
        ['name' => 'unit>create', 'menu' => 'Project Unit', 'group' => 'admin', 'type' => 2],
        ['name' => 'unit>edit', 'menu' => 'Project Unit', 'group' => 'admin', 'type' => 3],
        ['name' => 'unit>delete', 'menu' => 'Project Unit', 'group' => 'admin', 'type' => 4],

        ['name' => 'unit>request>read', 'menu' => 'Request Klaim Unit', 'group' => 'admin', 'type' => 1],
        ['name' => 'unit>request>action', 'menu' => 'Request Klaim Unit', 'group' => 'admin', 'type' => 5],

        ['name' => 'unit>request>history>read', 'menu' => 'History Klaim Unit', 'group' => 'admin', 'type' => 1],

        ['name' => 'unit>ownership>read', 'menu' => 'Ownership Unit', 'group' => 'admin', 'type' => 1],
        ['name' => 'unit>ownership>create', 'menu' => 'Ownership Unit', 'group' => 'admin', 'type' => 2],
        ['name' => 'unit>ownership>edit', 'menu' => 'Ownership Unit', 'group' => 'admin', 'type' => 3],
        ['name' => 'unit>ownership>delete', 'menu' => 'Ownership Unit', 'group' => 'admin', 'type' => 4],

        ['name' => 'facility>read', 'menu' => 'Facility Project', 'group' => 'admin', 'type' => 1],
        ['name' => 'facility>create', 'menu' => 'Facility Project', 'group' => 'admin', 'type' => 2],
        ['name' => 'facility>edit', 'menu' => 'Facility Project', 'group' => 'admin', 'type' => 3],
        ['name' => 'facility>delete', 'menu' => 'Facility Project', 'group' => 'admin', 'type' => 4],

        ['name' => 'developer>read', 'menu' => 'Developer', 'group' => 'admin', 'type' => 1],
        ['name' => 'developer>create', 'menu' => 'Developer', 'group' => 'admin', 'type' => 2],
        ['name' => 'developer>edit', 'menu' => 'Developer', 'group' => 'admin', 'type' => 3],
        ['name' => 'developer>delete', 'menu' => 'Developer', 'group' => 'admin', 'type' => 4],

        ['name' => 'developer>bank>read', 'menu' => 'Developer Bank', 'group' => 'admin', 'type' => 1],
        ['name' => 'developer>bank>create', 'menu' => 'Developer Bank', 'group' => 'admin', 'type' => 2],
        ['name' => 'developer>bank>edit', 'menu' => 'Developer Bank', 'group' => 'admin', 'type' => 3],
        ['name' => 'developer>bank>delete', 'menu' => 'Developer Bank', 'group' => 'admin', 'type' => 4],

        ['name' => 'developer>permission>edit', 'menu' => 'Developer Permission', 'group' => 'admin', 'type' => 3],
        ['name' => 'developer>feature>edit', 'menu' => 'Developer Feature', 'group' => 'admin', 'type' => 3],

        ['name' => 'support>read', 'menu' => 'Bantuan', 'group' => 'admin', 'type' => 1],
        ['name' => 'support>create', 'menu' => 'Bantuan', 'group' => 'admin', 'type' => 2],
        ['name' => 'support>edit', 'menu' => 'Bantuan', 'group' => 'admin', 'type' => 3],
        ['name' => 'support>delete', 'menu' => 'Bantuan', 'group' => 'admin', 'type' => 4],

        ['name' => 'emergency>read', 'menu' => 'Nomor Darurat', 'group' => 'admin', 'type' => 1],
        ['name' => 'emergency>create', 'menu' => 'Nomor Darurat', 'group' => 'admin', 'type' => 2],
        ['name' => 'emergency>edit', 'menu' => 'Nomor Darurat', 'group' => 'admin', 'type' => 3],
        ['name' => 'emergency>delete', 'menu' => 'Nomor Darurat', 'group' => 'admin', 'type' => 4],

        ['name' => 'bill>type>read', 'menu' => 'Type Tagihan', 'group' => 'admin', 'type' => 1],
        ['name' => 'bill>type>create', 'menu' => 'Type Tagihan', 'group' => 'admin', 'type' => 2],
        ['name' => 'bill>type>edit', 'menu' => 'Type Tagihan', 'group' => 'admin', 'type' => 3],
        ['name' => 'bill>type>delete', 'menu' => 'Type Tagihan', 'group' => 'admin', 'type' => 4],

        ['name' => 'term-condition>read', 'menu' => 'Term Condition', 'group' => 'admin', 'type' => 1],
        ['name' => 'term-condition>create', 'menu' => 'Term Condition', 'group' => 'admin', 'type' => 2],
        ['name' => 'term-condition>edit', 'menu' => 'Term Condition', 'group' => 'admin', 'type' => 3],
        ['name' => 'term-condition>delete', 'menu' => 'Term Condition', 'group' => 'admin', 'type' => 4],

        ['name' => 'faq>read', 'menu' => 'Setting FAQ', 'group' => 'admin', 'type' => 1],
        ['name' => 'faq>create', 'menu' => 'Setting FAQ', 'group' => 'admin', 'type' => 2],
        ['name' => 'faq>edit', 'menu' => 'Setting FAQ', 'group' => 'admin', 'type' => 3],
        ['name' => 'faq>delete', 'menu' => 'Setting FAQ', 'group' => 'admin', 'type' => 4],

        ['name' => 'feature>read', 'menu' => 'Setting Feature', 'group' => 'admin', 'type' => 1],
        ['name' => 'feature>create', 'menu' => 'Setting Feature', 'group' => 'admin', 'type' => 2],
        ['name' => 'feature>edit', 'menu' => 'Setting Feature', 'group' => 'admin', 'type' => 3],
        ['name' => 'feature>delete', 'menu' => 'Setting Feature', 'group' => 'admin', 'type' => 4],

        ['name' => 'role>read', 'menu' => 'Master Role', 'group' => 'admin', 'type' => 1],
        ['name' => 'role>create', 'menu' => 'Master Role', 'group' => 'admin', 'type' => 2],
        ['name' => 'role>edit', 'menu' => 'Master Role', 'group' => 'admin', 'type' => 3],
        ['name' => 'role>delete', 'menu' => 'Master Role', 'group' => 'admin', 'type' => 4],

        ['name' => 'permission>read', 'menu' => 'Master Permission', 'group' => 'admin', 'type' => 1],
        ['name' => 'permission>create', 'menu' => 'Master Permission', 'group' => 'admin', 'type' => 2],
        ['name' => 'permission>edit', 'menu' => 'Master Permission', 'group' => 'admin', 'type' => 3],
        ['name' => 'permission>delete', 'menu' => 'Master Permission', 'group' => 'admin', 'type' => 4],

        ['name' => 'location>province>read', 'menu' => 'Province', 'group' => 'admin', 'type' => 1],
        ['name' => 'location>province>create', 'menu' => 'Province', 'group' => 'admin', 'type' => 2],
        ['name' => 'location>province>edit', 'menu' => 'Province', 'group' => 'admin', 'type' => 3],
        ['name' => 'location>province>delete', 'menu' => 'Province', 'group' => 'admin', 'type' => 4],

        ['name' => 'location>city>read', 'menu' => 'City', 'group' => 'admin', 'type' => 1],
        ['name' => 'location>city>create', 'menu' => 'City', 'group' => 'admin', 'type' => 2],
        ['name' => 'location>city>edit', 'menu' => 'City', 'group' => 'admin', 'type' => 3],
        ['name' => 'location>city>delete', 'menu' => 'City', 'group' => 'admin', 'type' => 4],
    ];
    public static function allPermissions()
    {
        return self::PERMISSION;
    }
}
