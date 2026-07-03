import sys
try:
    import cv2
    has_cv2 = True
except ImportError:
    has_cv2 = False

try:
    from PIL import Image
    from pyzbar.pyzbar import decode
    has_pyzbar = True
except ImportError:
    has_pyzbar = False

image_path = r"C:\Users\IMRAN ALWI\.gemini\antigravity-ide\brain\6d9b0a61-4d69-4b6d-af99-aa6f00c57ee6\media__1782838000468.png"

print(f"Checking image: {image_path}")

if has_pyzbar:
    try:
        data = decode(Image.open(image_path))
        if data:
            print("Decoded via pyzbar:")
            for d in data:
                print(d.data.decode('utf-8'))
            sys.exit(0)
    except Exception as e:
        print(f"pyzbar error: {e}")

if has_cv2:
    try:
        img = cv2.imread(image_path)
        detector = cv2.QRCodeDetector()
        data, bbox, straight_qrcode = detector.detectAndDecode(img)
        if data:
            print("Decoded via OpenCV:")
            print(data)
            sys.exit(0)
    except Exception as e:
        print(f"OpenCV error: {e}")

print("Could not decode using pyzbar or OpenCV. Let's try installing pillow and pyzbar.")
