"use server";

import api from "@/fetcher/endpoint";
import {
  StudentDeleteDto,
  StudentPUpdateDto,
  StudentRequestDto,
  Students,
  StudentsSchema,
} from "@/fetcher/student.types";
import { revalidateTag } from "next/cache";

export async function getAllStudents(): Promise<Students> {
  const response = await fetch(api("students"), {
    next: {
      tags: ["student"],
    },
  });
  if (!response.ok) {
    const raw = await response.text();
    throw new Error(`Unable to receive students due to (${response.status}) ${raw}`);
  }

  const json = await response.json();
  return StudentsSchema.parse(json);
}

export async function createStudent(student: StudentRequestDto): Promise<void> {
  const formData = new FormData();
  for (const [key, value] of Object.entries(student)) {
    formData.append(key, value.toString());
  }

  const response = await fetch(api("students"), {
    method: "POST",
    body: formData,
  });
  if (!response.ok) {
    const raw = await response.text();
    throw new Error(`Unable to create student due to (${response.status}) ${raw}`);
  }

  revalidateTag("student");
}

export async function deleteStudent(student: StudentDeleteDto): Promise<void> {
  const response = await fetch(api("students?id=" + student.id), {
    method: "DELETE",
  });
  if (!response.ok) {
    const raw = await response.text();
    throw new Error(`Unable to delete student (${student.id}) due to (${response.status}) ${raw}`);
  }

  revalidateTag("student");
}

// broken
export async function partialUpdateStudent(id: number, student: StudentPUpdateDto): Promise<void> {
  const body = new FormData();
  body.append("id", id.toString());
  for (const [key, value] of Object.entries(student)) {
    body.append(key, value.toString());
  }

  const response = await fetch(api("students"), {
    method: "PATCH",
    body,
  });
  if (!response.ok) {
    const raw = await response.text();
    throw new Error(`Unable to update student (${id} => ${body}) due to (${response.status}) ${raw}`);
  }

  revalidateTag("student");
}
