#!/bin/bash

# Base paths
SRC_BASE="/home/abdurrehmanafzal/Documents/B1/b1properties-frontend/images"
DEST_BASE="/home/abdurrehmanafzal/Documents/B1/b1properties-frontend/images/organized"

# Function to slugify folder name
slugify() {
    echo "$1" | tr '[:upper:]' '[:lower:]' | sed -e 's/[^a-z0-9]/-/g' -e 's/--*/-/g' -e 's/^-//' -e 's/-$//'
}

# Function to find featured image for a property
find_featured() {
    local src_dir="$1"
    
    # Check directly in folder
    for file in "featured.webp" "home.webp" "home.png" "1.webp" "1.jpg" "1.png"; do
        if [[ -f "$src_dir/$file" ]]; then
            echo "$src_dir/$file"
            return
        fi
    done
    
    # Check in images subfolder
    for file in "featured.webp" "home.webp" "home.png" "home1.webp" "1.webp" "1.jpg" "1.png"; do
        if [[ -f "$src_dir/images/$file" ]]; then
            echo "$src_dir/images/$file"
            return
        fi
    done
    
    # Get first image if none found
    local first
    first=$(find "$src_dir" -maxdepth 2 -type f \( -name "*.webp" -o -name "*.jpg" -o -name "*.png" \) ! -name "qr*" ! -name "floorplan*" ! -name ".DS_Store" 2>/dev/null | sort | head -1)
    echo "$first"
}

# Function to process a property
process_property() {
    local category="$1"
    local src_name="$2"
    local src_dir="$SRC_BASE/$category/$src_name"
    
    if [[ ! -d "$src_dir" ]]; then
        echo "WARNING: Source directory not found: $src_dir"
        return
    fi
    
    local slug
    slug=$(slugify "$src_name")
    local dest_dir="$DEST_BASE/$category/$slug"
    
    # Skip if gallery has images already (fixed)
    local existing_count
    existing_count=$(find "$dest_dir/gallery" -type f -name "*.webp" 2>/dev/null | wc -l)
    if [[ $existing_count -gt 5 ]]; then
        echo "Skipping: $category/$src_name -> $slug (already has $existing_count gallery images)"
        return
    fi
    
    echo "Processing: $category/$src_name -> $slug"
    
    # Create directories
    mkdir -p "$dest_dir/gallery"
    mkdir -p "$dest_dir/thumbnail"
    
    # Clear existing gallery
    rm -f "$dest_dir/gallery/"*.webp
    
    # Find and copy featured image
    local featured
    featured=$(find_featured "$src_dir")
    if [[ -n "$featured" && -f "$featured" ]]; then
        cp "$featured" "$dest_dir/featured.webp"
        cp "$featured" "$dest_dir/thumbnail/featured.webp"
        echo "  Featured: $(basename "$featured")"
    else
        echo "  WARNING: No featured image found"
    fi
    
    # Find all gallery images using proper null-delimiter handling
    local counter=1
    
    # Check for images in root
    if [[ -d "$src_dir" ]]; then
        while IFS= read -r -d '' img; do
            num=$(printf "%03d" $counter)
            cp "$img" "$dest_dir/gallery/${num}.webp"
            ((counter++))
        done < <(find "$src_dir" -maxdepth 1 -type f \( -name "*.webp" -o -name "*.jpg" -o -name "*.png" \) ! -name "qr*" ! -name "floorplan*" ! -name ".DS_Store" ! -name "featured.webp" -print0 2>/dev/null | sort -z)
    fi
    
    # Check for images in images subfolder
    if [[ -d "$src_dir/images" ]]; then
        while IFS= read -r -d '' img; do
            num=$(printf "%03d" $counter)
            cp "$img" "$dest_dir/gallery/${num}.webp"
            ((counter++))
        done < <(find "$src_dir/images" -maxdepth 1 -type f \( -name "*.webp" -o -name "*.jpg" -o -name "*.png" \) ! -name "qr*" ! -name "floorplan*" ! -name ".DS_Store" ! -name "featured.webp" -print0 2>/dev/null | sort -z)
    fi
    
    echo "  Gallery: $((counter-1)) images"
}

echo "=== Re-processing properties with spaces in names ==="

# Sold properties with spaces
process_property "sold" "Framed Allure"
process_property "sold" "Riva Del Lusso"
process_property "sold" "Sole Mare"
process_property "sold" "Serene Versante"

# Offplan properties with spaces
process_property "offplan" "emaar the oasis"
process_property "offplan" "vela by ominyat"
process_property "offplan" "como residence"
process_property "offplan" "beach gate"
process_property "offplan" "bluewater bay"
process_property "offplan" "d1 west villa"
process_property "offplan" "lagoon views"
process_property "offplan" "design quarter"
process_property "offplan" "sunrise bay"
process_property "offplan" "tower b damac bay"

# Exclusive properties with spaces
process_property "exclusive" "Serene Versante"
process_property "exclusive" "Ocean Mansion"
process_property "exclusive" "Villa Frond A"
process_property "exclusive" "Emirates Hills"
process_property "exclusive" "Villa Palm"
process_property "exclusive" "Mansion Al Barari"
process_property "exclusive" "Garden Villa"
process_property "exclusive" "golden mile penthouse"
process_property "exclusive" "five sensoria lux"
process_property "exclusive" "Villa Frond D"
process_property "exclusive" "Villa Frond L"
process_property "exclusive" "Villa Valiente"

echo "=== Done ==="
