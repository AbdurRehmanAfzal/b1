#!/bin/bash

# Base paths
SRC_BASE="/home/abdurrehmanafzal/Documents/B1/b1properties-frontend/images"
DEST_BASE="/home/abdurrehmanafzal/Documents/B1/b1properties-frontend/images/organized"

# Function to slugify folder name
slugify() {
    echo "$1" | tr '[:upper:]' '[:lower:]' | sed -e 's/[^a-z0-9]/-/g' -e 's/--*/-/g' -e 's/^-//' -e 's/-$//'
}

# Function to find featured image for a property
# Priority: featured.webp > home.webp > home.png > 1.webp > first image found
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
    local first=$(find "$src_dir" -maxdepth 2 -type f \( -name "*.webp" -o -name "*.jpg" -o -name "*.png" \) ! -name "qr*" ! -name "floorplan*" ! -name ".DS_Store" 2>/dev/null | sort | head -1)
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
    
    local slug=$(slugify "$src_name")
    local dest_dir="$DEST_BASE/$category/$slug"
    
    echo "Processing: $category/$src_name -> $slug"
    
    # Create directories
    mkdir -p "$dest_dir/gallery"
    mkdir -p "$dest_dir/thumbnail"
    
    # Find and copy featured image
    local featured=$(find_featured "$src_dir")
    if [[ -n "$featured" && -f "$featured" ]]; then
        cp "$featured" "$dest_dir/featured.webp"
        cp "$featured" "$dest_dir/thumbnail/featured.webp"
        echo "  Featured: $(basename "$featured")"
    else
        echo "  WARNING: No featured image found"
    fi
    
    # Find all gallery images (excluding qr, floorplan, DS_Store, and the featured if already copied)
    local counter=1
    
    # Check for images in root and images subfolder
    for img_dir in "$src_dir" "$src_dir/images"; do
        if [[ -d "$img_dir" ]]; then
            for img in $(find "$img_dir" -maxdepth 1 -type f \( -name "*.webp" -o -name "*.jpg" -o -name "*.png" \) ! -name "qr*" ! -name "floorplan*" ! -name ".DS_Store" ! -name "featured.webp" 2>/dev/null | sort); do
                # Format counter with 3 digits
                local num=$(printf "%03d" $counter)
                cp "$img" "$dest_dir/gallery/${num}.webp"
                ((counter++))
            done
        fi
    done
    
    echo "  Gallery: $((counter-1)) images"
}

# Create destination directories
mkdir -p "$DEST_BASE/exclusive"
mkdir -p "$DEST_BASE/offplan"
mkdir -p "$DEST_BASE/sold"

echo "=== Processing Exclusive Properties ==="
# Exclusive properties
process_property "exclusive" "bvlgari"
process_property "exclusive" "Serene Versante"
process_property "exclusive" "j20"
process_property "exclusive" "Ocean Mansion"
process_property "exclusive" "g11"
process_property "exclusive" "k72"
process_property "exclusive" "Villa Frond A"
process_property "exclusive" "Emirates Hills"
process_property "exclusive" "Villa Palm"
process_property "exclusive" "Mansion Al Barari"
process_property "exclusive" "Garden Villa"
process_property "exclusive" "golden mile penthouse"
process_property "exclusive" "five sensoria lux"
process_property "exclusive" "opus"
process_property "exclusive" "Villa Frond D"
process_property "exclusive" "Villa Frond L"
process_property "exclusive" "Villa Valiente"

echo ""
echo "=== Processing Offplan Properties ==="
# Offplan properties
process_property "offplan" "palm-jebel-ali"
process_property "offplan" "edenpark"
process_property "offplan" "emaar the oasis"
process_property "offplan" "alba"
process_property "offplan" "vela by ominyat"
process_property "offplan" "jumeirah-asora-bay"
process_property "offplan" "como residence"
process_property "offplan" "lumena"
process_property "offplan" "vela vento"
process_property "offplan" "eden-hills"
process_property "offplan" "sanctuary"
process_property "offplan" "palace-villas-ostra"
process_property "offplan" "the-chedi"
process_property "offplan" "watercrest"
process_property "offplan" "grand-polo"
process_property "offplan" "acres"
process_property "offplan" "nad-al-sheba-gardens"
process_property "offplan" "liv-waterside"
process_property "offplan" "jebel-ali-village"
process_property "offplan" "akala-residences"
process_property "offplan" "altiera-heights"
process_property "offplan" "serenia-district"
process_property "offplan" "design quarter"
process_property "offplan" "ghaf-woods-distrikt-1"
process_property "offplan" "beach gate"
process_property "offplan" "bluewater bay"
process_property "offplan" "d1 west villa"
process_property "offplan" "lagoon views"
process_property "offplan" "naya"
process_property "offplan" "crestlane1"
process_property "offplan" "sunrise bay"
process_property "offplan" "tower b damac bay"

echo ""
echo "=== Processing Sold Properties ==="
# Sold properties
process_property "sold" "bluewater7"
process_property "sold" "Framed Allure"
process_property "sold" "Riva Del Lusso"
process_property "sold" "g23"
process_property "sold" "Sole Mare"
process_property "sold" "casadelsole"
process_property "sold" "zabeel"
process_property "sold" "royalatlantis"
process_property "sold" "jbr"
process_property "sold" "opus"
process_property "sold" "Serene Versante"

echo ""
echo "=== Done ==="
