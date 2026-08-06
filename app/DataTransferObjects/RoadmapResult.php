<?php

namespace App\DataTransferObjects;

class RoadmapResult
{
    public function __construct(
        public readonly string $summary,
        public readonly string $recommendedLegalStructure,
        public readonly array $steps,
        public readonly array $requiredDocuments,
        public readonly array $taxObligations,
        public readonly array $legalReferences,
        public readonly array $warnings,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            summary: $data['summary'] ?? '',
            recommendedLegalStructure: $data['recommended_legal_structure'] ?? '',
            steps: array_map(fn ($s) => [
                'titre' => $s['titre'] ?? $s['title'] ?? '',
                'description' => $s['description'] ?? '',
                'ordre' => $s['ordre'] ?? $s['order'] ?? 0,
            ], $data['steps'] ?? []),
            requiredDocuments: array_map(fn ($d) => [
                'nom' => $d['nom'] ?? $d['name'] ?? $d['titre'] ?? '',
                'description' => $d['description'] ?? '',
                'obligatoire' => $d['obligatoire'] ?? $d['required'] ?? true,
            ], $data['required_documents'] ?? $data['documents'] ?? []),
            taxObligations: array_map(fn ($t) => [
                'nom' => $t['nom'] ?? $t['name'] ?? $t['titre'] ?? '',
                'description' => $t['description'] ?? '',
                'frequence' => $t['frequence'] ?? $t['frequency'] ?? '',
                'obligatoire' => $t['obligatoire'] ?? $t['required'] ?? true,
            ], $data['tax_obligations'] ?? $data['taxes'] ?? []),
            legalReferences: array_map(fn ($r) => [
                'titre' => $r['titre'] ?? $r['title'] ?? '',
                'source' => $r['source'] ?? '',
            ], $data['legal_references'] ?? $data['references'] ?? []),
            warnings: array_map(fn ($w) => [
                'message' => $w['message'] ?? $w['warning'] ?? (is_string($w) ? $w : ''),
            ], $data['warnings'] ?? []),
        );
    }
}
