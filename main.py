import sys
import numpy as np
import pydicom
from PIL import Image

if len(sys.argv) < 2:
    print("Usage: python dcm_to_jpeg.py <input_file>")
    exit(1)

dcm_file = sys.argv[1]
jpeg_file = 'result.jpg'

image = pydicom.dcmread(dcm_file)

image = image.pixel_array.astype(float)

rs_image = (np.maximum(image,0)/image.max())*255
result = np.uint8(rs_image)

result = Image.fromarray(result)
result.save(jpeg_file)