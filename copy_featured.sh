#!/bin/bash

SRC_BASE="/home/abdurrehmanafzal/Documents/B1/b1properties-frontend/images"
DEST_BASE="/home/abdurrehmanafzal/Documents/B1/b1properties-frontend/images/organized"

# Function to slugify folder name
slugify() {
    echo "$1" | tr '[:upper:]' '[:lower:]' | sed -e 's/[^a-z0-9]/-/g' -e 's/--*/-/g' -e 's/^-//' -e 's/-$//'
}

# Copy featured image
copy_featured() {
    local category="$1"
    local property="$2"
    local src_image="$3"
    
    local slug=$(slugify "$property")
    local dest_dir="$DEST_BASE/$category/$slug"
    local src_path="$SRC_BASE/$category/$src_image"
    
    if [[ -f "$src_path" ]]; then
        cp "$src_path" "$dest_dir/featured.webp"
        echo "OK: $category/$slug <- $src_image"
    else
        echo "ERROR: Source not found: $src_path"
    fi
}

echo "=== EXCLUSIVE PROPERTIES ==="
copy_featured "exclusive" "bvlgari" "bvlgari/1.webp"
copy_featured "exclusive" "Serene Versante" "Serene Versante/images/home.webp"
copy_featured "exclusive" "j20" "j20/images/home.webp"
copy_featured "exclusive" "Ocean Mansion" "Ocean Mansion/images/EXTERIOR_3-2.webp"
copy_featured "exclusive" "g11" "g11/images/home.png"
copy_featured "exclusive" "k72" "k72/1.webp"
copy_featured "exclusive" "Villa Frond A" "Villa Frond A/images/1.webp"
copy_featured "exclusive" "Emirates Hills" "Emirates Hills/featured.webp"
copy_featured "exclusive" "Villa Palm" "Villa Palm/images/home.webp"
copy_featured "exclusive" "Mansion Al Barari" "Mansion Al Barari/images/home.webp"
copy_featured "exclusive" "Garden Villa" "Garden Villa/images/home1.webp"
copy_featured "exclusive" "golden mile penthouse" "golden mile penthouse/26.webp"
copy_featured "exclusive" "five sensoria lux" "five sensoria lux/7.webp"
copy_featured "exclusive" "opus" "opus/home.webp"
copy_featured "exclusive" "Villa Frond D" "Villa Frond D/images/home.webp"
copy_featured "exclusive" "Villa Frond L" "Villa Frond L/images/36-2.webp"
copy_featured "exclusive" "Villa Valiente" "Villa Valiente/images/1.webp"

echo ""
echo "=== OFFPLAN PROPERTIES ==="
copy_featured "offplan" "palm-jebel-ali" "palm-jebel-ali/1.webp"
copy_featured "offplan" "edenpark" "edenpark/2.webp"
copy_featured "offplan" "emaar the oasis" "emaar the oasis/2.webp"
copy_featured "offplan" "alba" "alba/16.webp"
copy_featured "offplan" "vela by ominyat" "vela by ominyat/34.webp"
copy_featured "offplan" "jumeirah-asora-bay" "jumeirah-asora-bay/4.webp"
copy_featured "offplan" "como residence" "como residence/8.webp"
copy_featured "offplan" "lumena" "lumena/2.webp"
copy_featured "offplan" "vela vento" "vela vento/3.webp"
copy_featured "offplan" "eden-hills" "eden-hills/2.webp"
copy_featured "offplan" "sanctuary" "sanctuary/2.webp"
copy_featured "offplan" "palace-villas-ostra" "palace-villas-ostra/4.webp"
copy_featured "offplan" "the-chedi" "the-chedi/2.webp"
copy_featured "offplan" "watercrest" "watercrest/29.webp"
copy_featured "offplan" "grand-polo" "grand-polo/1.webp"
copy_featured "offplan" "acres" "acres/5.webp"
copy_featured "offplan" "nad-al-sheba-gardens" "nad-al-sheba-gardens/5.webp"
copy_featured "offplan" "liv-waterside" "liv-waterside/1.webp"
copy_featured "offplan" "jebel-ali-village" "jebel-ali-village/2.webp"
copy_featured "offplan" "akala-residences" "akala-residences/1.webp"
copy_featured "offplan" "altiera-heights" "altiera-heights/1.webp"
copy_featured "offplan" "serenia-district" "serenia-district/4.webp"
copy_featured "offplan" "design quarter" "design quarter/3.webp"
copy_featured "offplan" "ghaf-woods-distrikt-1" "ghaf-woods-distrikt-1/4.webp"

echo ""
echo "=== SOLD PROPERTIES ==="
copy_featured "sold" "Framed Allure" "Framed Allure/images/1.jpg"
copy_featured "sold" "Riva Del Lusso" "Riva Del Lusso/images/39.webp"
copy_featured "sold" "Sole Mare" "Sole Mare/images/7.webp"
copy_featured "sold" "casadelsole" "casadelsole/images/11.webp"
copy_featured "sold" "zabeel" "zabeel/images/7.webp"
copy_featured "sold" "royalatlantis" "royalatlantis/images/1.png"
copy_featured "sold" "jbr" "jbr/images/0.png"
copy_featured "sold" "bluewater7" "bluewater7/images/02.webp"
copy_featured "sold" "opus" "opus/images/6.webp"
copy_featured "sold" "g23" "g23/images/home.webp"
copy_featured "sold" "Serene Versante" "Serene Versante/images/home.webp"

echo ""
echo "=== DONE ==="
