<?php
// Generate slug based on product name
function generateSlug($productName)
{
  $lowerCaseProductName = strtolower($productName);

  // Remove special characters and replace spaces with hyphens
  $slug = preg_replace('/[^a-z0-9\s-]/', '', $lowerCaseProductName);

  // Replace spaces or multiple hyphens with a single hyphen
  $slug = preg_replace('/[\s-]+/', '-', $slug);

  // Trim hyphens from the beginning and end
  $slug = trim($slug, '-');

  return $slug;
}
